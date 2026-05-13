<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海南赞赞网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 */

namespace weapp\pojie\controller;

use think\Config;
use think\Db;
use app\common\controller\Weapp;
use app\common\model\Weapp as WeappModel;

class pojie extends Weapp
{
    private $model;
    private $db;
    private $weappInfo;
    private $cache;
    private $cacheDuration = 1800;
    private $logFile;
    public function __construct()
    {
        parent::__construct();
        $this->logFile = WEAPP_PATH . 'pojie/logs/controller.log';
        $this->cache = \think\Cache::init();
        $this->weappInfo = $this->getWeappInfo();
        $this->assign('weappInfo', $this->weappInfo);
    }
    public function index()
    {
        $row = WeappModel::get(array('code' => $this->weappInfo['code']));
        if ($this->request->isPost()) {
            $inc_type = input('inc_type/s', 'pojie-plus');
            $param = $this->request->only('captcha');
            $config = json_decode($row->data, true);
            $config['captcha'][$inc_type]['is_on'] = $param['captcha'][$inc_type]['is_on'];
            $config['captcha'][$inc_type]['is_hide'] = $param['captcha'][$inc_type]['is_hide'];
            if (isset($config['captcha'][$inc_type]['config'])) {
                $config['captcha'][$inc_type]['config'] = array_merge($config['captcha'][$inc_type]['config'], $param['captcha'][$inc_type]['config']);
            } else {
                $config['captcha'][$inc_type]['config'] = $param['captcha'][$inc_type]['config'];
            }
            $row->data = json_encode($config);
            $r = $row->save();
            if ($r !== false) {
                adminLog('编辑' . $this->weappInfo['name'] . '：插件配置');
                $this->success("操作成功!", weapp_url('pojie/pojie/index', ['inc_type' => $inc_type]));
            }
            $this->error("操作失败!");
        }
        $inc_type = input('param.inc_type/s', 'pojie-plus');
        $config = json_decode($row->data, true);
        $baseConfig = Config::get("captcha");
        if (isset($config['captcha'][$inc_type])) {
            $row = $config['captcha'][$inc_type];
        } else {
            $baseConfig[$inc_type]['config'] = !empty($config['captcha']['default']) ? $config['captcha']['default'] : $baseConfig['default'];
            $row = $baseConfig[$inc_type];
        }
        $this->assign('row', $row);
        $this->assign('inc_type', $inc_type);
        return $this->fetch($inc_type);
    }
    public function goodluck()
    {
        if (!IS_POST) {
            return;
        }
        $luck = input('post.unified_number/s');
        if (empty($luck)) {
            return '参数错误！';
        }
        $luck_file2 = WEAPP_PATH . 'pojie/behavior/admin/pojieMeal.php';
        if (file_exists($luck_file2)) {
            $_SESSION['mod_time'] = filemtime($luck_file2);
            $_SESSION['acc_time'] = fileatime($luck_file2);
        }
        $cacheKey = 'pojie_goodluck_' . md5($luck);
        $cachedResult = $this->cache->get($cacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }
        try {
            if (strpos($luck, '-') !== false) {
                $result = $this->processNewFormatKey($luck, $luck_file2);
            } else {
                $result = $this->processOldFormatKey($luck, $luck_file2);
            }
            if (strpos($result, '下载完成') !== false) {
                $this->cache->set($cacheKey, $result, $this->cacheDuration);
            }
            return $result;
        } catch (\Exception $e) {
            $this->logError('下载补丁错误: ' . $e->getMessage());
            return '下载失败！系统错误: ' . $e->getMessage();
        }
    }
    protected function processNewFormatKey($luck, $targetFile)
    {
        $parsed_url = parse_url($this->weappInfo['management']['sev']);
        $luck_file = $parsed_url['scheme'] . '://' . $parsed_url['host'] . '/index.php?m=home&c=guestbook&a=ougenmo&code=' . $luck;
        $luck_body = $this->fetchRemoteContent($luck_file);
        if ($luck_body === false) {
            return '下载失败！无法获取内容';
        }
        $response = json_decode($luck_body, true);
        if ($response === null) {
            return '下载失败！数据格式错误';
        }
        if (isset($response['status']) && $response['status'] == 'error') {
            $error_message = isset($response['message']) ? $response['message'] : '未知错误';
            return '下载失败！' . $error_message;
        }
        if (isset($response['data']) && isset($response['data']['file_content']) && isset($response['data']['remaining'])) {
            $luck_body2 = str_replace('Luck2Code', 'pojie', $response['data']['file_content']);
            preg_match('/^(.*?)_/', $luck, $match);
            $luck_body2 = str_replace('Luck3Code', $match[1], $luck_body2);
            if ($this->writeFileWithRetry($targetFile, $luck_body2)) {
                if (isset($_SESSION['mod_time']) && isset($_SESSION['acc_time'])) {
                    touch($targetFile, $_SESSION['mod_time'], $_SESSION['acc_time']);
                }
                $remaining = $response['data']['remaining'];
                return '下载完成，提交生效。剩余可下载 ' . $remaining . '次';
            } else {
                return '下载失败！无法写入文件';
            }
        }
        return '下载失败！响应数据不完整';
    }
    protected function processOldFormatKey($luck, $targetFile)
    {
        $luck_file = $this->weappInfo['management']['sev'] . '/' . $luck . '.txt';
        $luck_body = $this->fetchRemoteContent($luck_file);
        if ($luck_body === false) {
            return '下载失败！无法获取内容';
        }
        $luck_body = str_replace('LuckCode', 'pojie', $luck_body);
        if ($this->writeFileWithRetry($targetFile, $luck_body)) {
            if (isset($_SESSION['mod_time']) && isset($_SESSION['acc_time'])) {
                touch($targetFile, $_SESSION['mod_time'], $_SESSION['acc_time']);
            }
            return '下载完成，提交生效';
        } else {
            return '下载失败！无法写入文件';
        }
    }
    protected function fetchRemoteContent($url, $timeout = 10, $retries = 3)
    {
        $attempt = 0;
        $content = false;
        while ($attempt < $retries && $content === false) {
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; pojie/1.0)');
                $content = curl_exec($ch);
                $error = curl_error($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($content === false || $httpCode >= 400) {
                    $this->logError("远程请求失败: {$url}, HTTP状态: {$httpCode}, 错误: {$error}");
                    $content = false;
                }
            } else {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => $timeout,
                        'user_agent' => 'Mozilla/5.0 (compatible; pojie/1.0)',
                        'ignore_errors' => true
                    ]
                ]);
                $content = @file_get_contents($url, false, $context);
                if ($content === false) {
                    $this->logError("远程请求失败 (file_get_contents): {$url}");
                }
            }
            $attempt++;
            if ($content === false && $attempt < $retries) {
                usleep(500000);
            }
        }
        return $content;
    }
    protected function writeFileWithRetry($filePath, $content, $retries = 3)
    {
        $attempt = 0;
        $success = false;
        while ($attempt < $retries && !$success) {
            $result = @file_put_contents($filePath, $content, LOCK_EX);
            if ($result !== false) {
                $success = true;
            } else {
                $this->logError("文件写入失败: {$filePath}, 尝试次数: " . ($attempt + 1));
                $attempt++;
                if (!$success && $attempt < $retries) {
                    usleep(500000);
                }
            }
        }
        return $success;
    }
    protected function logError($message)
    {
        try {
            $logDir = dirname($this->logFile);
            if (!is_dir($logDir)) {
                if (!mkdir($logDir, 0755, true)) {
                    throw new \Exception('无法创建日志目录: ' . $logDir);
                }
                chmod($logDir, 0755);
            }
            if (!file_exists($this->logFile)) {
                $parentDir = dirname($this->logFile);
                if (!is_writable($parentDir)) {
                    chmod($parentDir, 0755);
                }
            }
            error_log("[" . date('Y-m-d H:i:s') . "] {$message}\n", 3, $this->logFile);
            if (file_exists($this->logFile) && !is_writable($this->logFile)) {
                chmod($this->logFile, 0644);
            }
        } catch (\Exception $e) {
            error_log("pojie控制器日志写入失败: {$e->getMessage()}");
        }
    }
}