<?php $this->load->view('header')?>
<div id="wraper">
    <div class="site_route">
        您的位置 : 个人中心
    </div>
    <div class="content clearfloat">
        <div class="user_center clearfloat">
            <div class="title">
                <h1 class="color_1">嘎嘎嘎</h1>
                <span class='email color_2'>（<?php echo isset($row['user_name']) ? $row['user_name'] : '';?>）</span>
            </div>
            <p class="color_2">欢迎妈妈，您已经在蜡笔画留下了足迹，不做懵懂的妈妈，在这里学习、分享、买东西...</p>
            <div class="user_info">
                <form id="form" action="/user/edit_info" method="post">
                    <textarea class="color_3" name="user_info" readonly="readonly" id="textarea" > <?php echo isset($row['user_info']) ? $row['user_info'] : '这是一位懒妈妈...还没有编辑个人介绍哦... ' ;?> </textarea>
                    <div class="button">
                        <input type="submit" class="submit color_1" name="doSubmit" id="edit" onclick=" return trigger_edit()" value="编辑个人介绍">
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <div class="head">
                <h3>妈妈关注标签</h3>
            </div>
            <div class="tag_list">
               <!-- loop start -->
               <?php foreach($tagNameArr as $v){ ?>
               <div class="tag_box">
                   <div class="tag"><a href="#"><?php echo $v['name'];?></a></div><img src="/img/love.jpg" />
               </div> 
               <?php } ?>
               <!-- loop end -->
               <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer')?>

