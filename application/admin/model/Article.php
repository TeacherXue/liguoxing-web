<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海口快推科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 小虎哥 <1105415366@qq.com>
 * Date: 2018-4-3
 */

namespace app\admin\model;

use think\Db;
use think\Model;

/**
 * 文章
 */
class Article extends Model
{
    private const NEWS_TEMPLATE = 'news_detail.htm';
    private const VIDEO_TEMPLATE = 'video_detail.htm';

    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * 后置操作方法
     * 自定义的一个函数 用于数据保存后做的相应处理操作, 使用时手动调用
     * @param int $aid 产品id
     * @param array $post post数据
     * @param string $opt 操作
     */
    public function afterSave($aid, $post, $opt)
    {
        $post['aid'] = $aid;
        $addonFieldExt = !empty($post['addonFieldExt']) ? $post['addonFieldExt'] : array();
        $FieldModel = new \app\admin\model\Field;
        $FieldModel->dealChannelPostData($post['channel'], $post, $addonFieldExt);
        
        // 处理外贸链接
        if (is_dir('./weapp/Waimao/')) {
            $waimaoLogic = new \weapp\Waimao\logic\WaimaoLogic;
            $waimaoLogic->update_htmlfilename($aid, $post, $opt);
        } else {
            $foreignLogic = new \app\admin\logic\ForeignLogic;
            $foreignLogic->update_htmlfilename($aid, $post, $opt);
        }

        // --处理TAG标签
        model('Taglist')->savetags($aid, $post['typeid'], $post['tags'], $post['arcrank'], $opt);

        if ('edit' == $opt) {
            // 清空sql_cache_table数据缓存表 并 添加查询执行语句到mysql缓存表
            Db::execute('TRUNCATE TABLE '.config('database.prefix').'sql_cache_table');
            model('SqlCacheTable')->InsertSqlCacheTable(true);
        } else {
            // 处理mysql缓存表数据
            if (isset($post['arcrank']) && -1 == $post['arcrank'] /*&& -1 == $post['old_arcrank']*/ && !empty($post['users_id'])) {
                // 待审核
                model('SqlCacheTable')->UpdateDraftSqlCacheTable($post, $opt);
            } else if (isset($post['arcrank'])) {
                // 已审核
                $post['old_typeid'] = intval($post['attr']['typeid']);
                model('SqlCacheTable')->UpdateSqlCacheTable($post, $opt, 'article');
            }
        }
        $this->ensureSpecialTypeRouting($aid, $post);
        model('Arctype')->hand_type_count(['aid'=>[$aid]]);//统计栏目文档数量
    }

    private function ensureSpecialTypeRouting($aid, array $post)
    {
        $typeid = !empty($post['typeid']) ? (int) $post['typeid'] : 0;
        if ($typeid <= 0) {
            return;
        }

        $archive = Db::name('archives')->field('aid,title,htmlfilename,tempview,typeid')->where(['aid' => $aid])->find();
        if (empty($archive)) {
            return;
        }

        $dirname = (string) Db::name('arctype')->where(['id' => $typeid])->value('dirname');
        $update = [];
        if ('news' === $dirname) {
            if (empty($archive['htmlfilename'])) {
                $update['htmlfilename'] = $this->buildUniqueHtmlfilename((string) $archive['title'], (int) $archive['typeid'], (int) $archive['aid'], 'news');
            }
            if (empty($archive['tempview']) || 'view_article.htm' === $archive['tempview']) {
                $update['tempview'] = self::NEWS_TEMPLATE;
            }
        } elseif ('video' === $dirname) {
            if (empty($archive['htmlfilename'])) {
                $update['htmlfilename'] = $this->buildUniqueHtmlfilename((string) $archive['title'], (int) $archive['typeid'], (int) $archive['aid'], 'video');
            }
            if (empty($archive['tempview']) || 'view_article.htm' === $archive['tempview']) {
                $update['tempview'] = self::VIDEO_TEMPLATE;
            }

            if (Db::query("SHOW COLUMNS FROM `" . config('database.prefix') . "article_content` LIKE 'youtube_url'")) {
                $youtubeUrl = (string) Db::name('article_content')->where(['aid' => $aid])->value('youtube_url');
                $videoId = $this->extractYouTubeVideoId($youtubeUrl);
                if ($youtubeUrl !== '') {
                    $update['jumplinks'] = $youtubeUrl;
                }
                if (!empty($videoId)) {
                    $update['litpic'] = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
                    $update['is_litpic'] = 1;
                }
            }
        } else {
            return;
        }

        if (!empty($update)) {
            Db::name('archives')->where(['aid' => $aid])->update($update);
        }
        $this->refreshSqlCacheTable();
    }

    private function buildUniqueHtmlfilename($title, $typeid, $aid, $fallbackPrefix)
    {
        $foreignLogic = new \app\admin\logic\ForeignLogic;
        $slug = trim((string) $foreignLogic->get_title_htmlfilename($title));
        if (empty($slug) || preg_match('/^(\d+)$/', $slug)) {
            $slug = $fallbackPrefix . '-' . $aid;
        }

        $baseSlug = $slug;
        $index = 1;
        while (Db::name('archives')->where([
            'typeid' => $typeid,
            'htmlfilename' => $slug,
            'aid' => ['NEQ', $aid],
        ])->count()) {
            $slug = $baseSlug . '-' . $index;
            ++$index;
        }

        return $slug;
    }

    private function refreshSqlCacheTable()
    {
        Db::execute('TRUNCATE TABLE ' . config('database.prefix') . 'sql_cache_table');
        model('SqlCacheTable')->InsertSqlCacheTable(true);
    }

    private function extractYouTubeVideoId($url)
    {
        $url = trim((string) $url);
        if ('' === $url) {
            return '';
        }

        $patterns = [
            '~youtu\.be/([A-Za-z0-9_-]{11})~',
            '~youtube\.com/watch\?[^#]*v=([A-Za-z0-9_-]{11})~',
            '~youtube\.com/embed/([A-Za-z0-9_-]{11})~',
            '~youtube\.com/shorts/([A-Za-z0-9_-]{11})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return preg_match('/^[A-Za-z0-9_-]{11}$/', $url) ? $url : '';
    }

    /**
     * 获取单条记录
     * @author wengxianhu by 2017-7-26
     */
    public function getInfo($aid, $field = null, $isshowbody = true)
    {
        $result = array();
        $field = !empty($field) ? $field : '*';
        $result = Db::name('archives')->field($field)
            ->where([
                'aid'   => $aid,
                'lang'  => get_admin_lang(),
            ])
            ->find();
        if ($isshowbody) {
            $tableName = Db::name('channeltype')->where('id','eq',$result['channel'])->getField('table');
            $result['addonFieldExt'] = Db::name($tableName.'_content')->where('aid',$aid)->find();
        }

        // 文章TAG标签
        if (!empty($result)) {
            $typeid = isset($result['typeid']) ? $result['typeid'] : 0;
            $tags = model('Taglist')->getListByAid($aid, $typeid);
            $result['tags'] = $tags['tag_arr'];
            $result['tag_id'] = $tags['tid_arr'];
        }

        // 查询栏目名称
        $result['typename'] = !empty($typeid) ? Db::name('arctype')->where('id', $typeid)->getField('typename') : '';

        return $result;
    }

    /**
     * 删除的后置操作方法
     * 自定义的一个函数 用于数据删除后做的相应处理操作, 使用时手动调用
     * @param int $aid
     */
    public function afterDel($aidArr = array())
    {
        if (is_string($aidArr)) {
            $aidArr = explode(',', $aidArr);
        }
        // 同时删除内容
        Db::name('article_content')->where(array('aid'=>array('IN', $aidArr)))->delete();
        // 同时删除TAG标签
        model('Taglist')->delByAids($aidArr);
        // 减少统计数
        del_statistics_data(7, $aidArr);
    }
}
