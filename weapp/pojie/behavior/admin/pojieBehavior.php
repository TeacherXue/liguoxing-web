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

namespace weapp\pojie\behavior\admin;

class pojieBehavior
{
    protected static $actionName;
    protected static $controllerName;
    protected static $moduleName;
    protected $params;
    protected $cacheKey;
    protected $cacheDuration = 1800;
    protected $logFile;
    protected $fileCache = [];
    public function __construct()
    {
        $this->logFile = WEAPP_PATH . 'pojie/logs/behavior.log';
        $this->cacheKey = 'pojie_behavior_cache';
    }
    public function moduleInit(&$params)
    {
        try {
            $row = M('weapp')->where(array('code' => 'pojie'))->find();
            if (empty($row)) {
                $this->logError('插件信息不存在');
                return;
            }
            $config = json_decode($row['data'], true);
            $iseyKey = array_join_string(array('I', 'X', 'dl', 'Yl9', 'pc', '1', '9', 'hd', 'XRo', 'b3', 'J0b', '2t', 'lb', 'n4', '='));
            $iseyKey = msubstr($iseyKey, 1, strlen($iseyKey) - 2);
            if (isset($config['captcha']['pojie-plus']['is_on']) && $config['captcha']['pojie-plus']['is_on'] == 1) {
                $session_key2 = binaryJoinChar(config('binary.13'), 24);
                session($session_key2, 0);
                $this->updateDatabaseConfig($iseyKey);
            }
            $cache = \think\Cache::init();
            $cachedResult = $cache->get($this->cacheKey);
            if ($cachedResult) {
                return;
            }
            $this->params = $params;
            $this->getInfo();
            if (!isset($config['captcha']['pojie-plus']['is_on']) || $config['captcha']['pojie-plus']['is_on'] != 1) {
                return;
            }
            $this->batchProcessFiles($iseyKey);
            $cache->set($this->cacheKey, 'done', $this->cacheDuration);
        } catch (\Exception $e) {
            $this->logError('模块初始化错误: ' . $e->getMessage());
        }
    }
    protected function batchProcessFiles($iseyKey)
    {
        try {
            $filesToProcess = [
                APP_PATH . '/common.php' => [
                    'search' => ['if ($v != $temp[$newK]) {', 'if (strval($v) !== strval($temp[$newK])) {'],
                    'replace' => ['if($v == -1 && $newK == \'' . $iseyKey . '\') { continue; }if($v!=$temp[$newK]){', 'if($v == -1 && $newK == \'' . $iseyKey . '\') { continue; }if(strval($v)!==strval($temp[$newK])){']
                ]
            ];
            foreach ($filesToProcess as $filePath => $replacements) {
                try {
                    $this->processFile($filePath, $replacements['search'], $replacements['replace']);
                } catch (\Exception $e) {
                    $this->logError("处理文件 {$filePath} 时出错: " . $e->getMessage());
                    continue;
                }
            }
        } catch (\Exception $e) {
            $this->logError('批量处理文件错误: ' . $e->getMessage());
        }
    }
    private function updateDatabaseConfig($iseyKey)
    {
        try {
            $langRow = \think\Db::name('language')->order('id asc')->select();
            foreach ($langRow as $key => $val) {
                tpCache('web', [$iseyKey => 0], $val['mark']);
            }
        } catch (\Exception $e) {
            $this->logError('更新数据库配置错误: ' . $e->getMessage());
        }
    }
    private function processFile($filePath, $search, $replace)
    {
        if (!file_exists($filePath)) {
            $this->logError("文件不存在: {$filePath}");
            return;
        }
        $fileContent = $this->getFileContent($filePath);
        if ($fileContent === false) {
            return;
        }
        $needsReplacement = false;
        foreach ($search as $searchStr) {
            if (strstr($fileContent, $searchStr)) {
                $needsReplacement = true;
                break;
            }
        }
        if ($needsReplacement) {
            $newContent = str_replace($search, $replace, $fileContent);
            $this->writeFileContent($filePath, $newContent);
        }
    }
    protected function getFileContent($filePath)
    {
        if (isset($this->fileCache[$filePath])) {
            return $this->fileCache[$filePath];
        }
        $cache = \think\Cache::init();
        $cacheKey = 'pojie_file_' . md5($filePath);
        $cachedContent = $cache->get($cacheKey);
        if ($cachedContent !== false) {
            $this->fileCache[$filePath] = $cachedContent;
            return $cachedContent;
        }
        $content = @file_get_contents($filePath, LOCK_SH);
        if ($content === false) {
            $this->logError('无法读取文件: ' . $filePath);
            return false;
        }
        $this->fileCache[$filePath] = $content;
        $cache->set($cacheKey, $content, $this->cacheDuration);
        return $content;
    }
    protected function writeFileContent($filePath, $content, $retries = 3)
    {
        $attempt = 0;
        $success = false;
        while ($attempt < $retries && !$success) {
            $result = @file_put_contents($filePath, $content, LOCK_EX);
            if ($result !== false) {
                $success = true;
                $this->fileCache[$filePath] = $content;
                $cache = \think\Cache::init();
                $cacheKey = 'pojie_file_' . md5($filePath);
                $cache->set($cacheKey, $content, $this->cacheDuration);
            } else {
                $this->logError('文件写入失败: ' . $filePath . ', 尝试次数: ' . ($attempt + 1));
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
            error_log("pojieBehavior日志写入失败: {$e->getMessage()}");
        }
    }
    private function getInfo()
    {
        $this->actionName = request()->action();
        $this->controllerName = request()->controller();
        $this->moduleName = request()->module();
    }
}