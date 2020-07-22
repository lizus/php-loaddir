<?php
namespace Lizus\LoadDir;

/*
It is a static class for getting or loading files from a directory and its subdirectories
use sample:

use \Lizus\LoadDir\LoadDir;
$load=LoadDir::load_files(__DIR__.'/function');

 */

class LoadDir
{
  /**
   * get files from $folder, $levels decide the depth of subdirectories
   * @since 0.0.1
   * @param  string  $folder   the path of folder,such as __DIR__.'/function'
   * @param  string  $fileType want to get which filetype
   * @param  integer $levels   the depth of subdirectories
   * @return array            files array or empty array
   */
  public static function get_files($folder,$fileType='*',$levels=3){
    $files = [];
    if (empty($folder)) return $files;
    if ($levels>0) {
      $folder=rtrim($folder,'/');
      $files=glob($folder.'/*.'.$fileType);
      if (empty($files)) $files=[];
      $has_folder=glob($folder.'/*',GLOB_ONLYDIR);
      if ($has_folder) {
        $folder=$folder.'/*';
        $levels--;
        $files=array_merge($files,self::get_files($folder,$fileType,$levels));
      }
    }
    return $files;
  }

  /**
   * load files from $folder
   * @since 0.0.1
   * @param  string  $folder   [directory want load]
   * @param  string  $fileType [file type want load, must can be used in `require_once`, default is php]
   * @param  string  $prefix   [the prefix string of the file name, if it is set, only files have the prefix will loaded]
   * @param  integer $levels   [depth of subdirectories]
   * @return boolean            [true if loaded, false if not]
   */
  public static function load_files($folder,$fileType='php',$prefix='',$levels=3){
    if (empty($folder) || empty($fileType)) return false;
    $files=self::get_files($folder,$fileType,$levels);
    if (!empty($files)) {
      foreach ($files as $f) {
        if (empty($prefix) || preg_match('/\/'.$prefix.'[-_0-9a-zA-Z]+\.'.$fileType.'$/',$f)) {
          require_once $f;
        }
      }
      return true;
    }
    return false;
  }
}
