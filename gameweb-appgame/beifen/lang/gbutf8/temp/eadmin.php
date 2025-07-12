<!DOCTYPE HTML>
<html>
<head>
  <title>数据备份系统后台</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="/template/admin/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
   <link href="/template/admin/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="/template/admin/assets/css/main-min.css" rel="stylesheet" type="text/css" />
   <link href="/template/admin/assets/css/jia.css" rel="stylesheet" type="text/css" />
   
</head>
<body>
  <div class="header">
    <div class="dl-title">数据备份系统后台</div>
    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo $loginin?></span><a href="phome.php?phome=exit" title="退出系统" class="dl-log-quit">[退出]</a><a href="http://bbs.yyjia.com/forum.php?mod=forumdisplay&fid=2" target="_blank" title="新手指南" class="dl-log-quit">新手指南</a>
    </div>
  </div>
  <div class="content">
    <div class="dl-main-nav">
      <ul id="J_Nav"  class="nav-list ks-clear">
        <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">数据备份</div></li>
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">
    </ul>
  </div>
  <script type="text/javascript" src="/template/admin/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="/template/admin/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="/template/admin/assets/js/config-min.js"></script>
  <script>
    BUI.use('common/main',function(){
      var config = [{
          id:'peizhi', 
          homePage:'peizhi_cssz',
          menu:[{
              text:'备份菜单栏',
              items:[
                {id:'peizhi_cssz',text:'参数设置',href:'SetDb.php',closeable:false},
                {id:'peizhi_sjbf',text:'备份数据',href:'ChangeDb.php'},
                {id:'peizhi_hfsj',text:'恢复数据',href:'ReData.php'},
                {id:'peizhi_glbf',text:'管理备份目录',href:'ChangePath.php'}
              ]
            }]
          }];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
</body>
</html>
