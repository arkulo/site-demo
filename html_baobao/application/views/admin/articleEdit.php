<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文章修改网站后台管理</title>
<link rel="stylesheet" href="/adminStatic/css/common_new.css" type="text/css" />
</head>
<body>
<div id="man_zone">
	<h5>&nbsp;&nbsp;◆ 文章修改&nbsp;&raquo;&nbsp;<span style='color:red'><b>*</b></span> 代表必填项；</h5>
    <?php echo form_open(site_url('admin/article/saveEdit/'.$id), array('class'=>"jnice","onsubmit"=>"return check_form()"));?>
  	<table width="96%" border="0" align="center"  cellpadding="3" cellspacing="1" class="table_style">
    	<tr>
      		<td class="left_title_1"><span style='color:red'>*</span>&nbsp;所属栏目</td>
      		<td>
      			<select name="one" id="one" onchange="changeOn('one',this.value,1)">
                	<option value="0">-- 请选择 --</option>
                    <?php if(!empty($one_section)) {foreach($one_section as $k=>$v) {?>
                    <option value="<?php echo $v['id']?>" <?php if($one != '' && $one['id'] == $v['id']){ echo 'selected';}?> style="background-color:#FFC;"><?php echo $v['name']?></option>
                    <?php }} ?>
                </select>
                <select style="display:inline;" name="two" id="two" onchange="changeOn('two',this.value,1)">
                    <option value='0'>-- 请选择 --</option>
                    <?php if($two_section != ''){ foreach($two_section as $k=>$v){ ?>
                    <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $two['id']) echo 'selected'; ?>><?php echo $v['name'];?></option>
                    <?php }} ?>
                </select>
                <select style="display:inline;" name="three" id="three" onchange="changeOn('three',this.value),1">
                    <option value='0'>-- 请选择 --</option>
                    <?php if($three_section != ''){ foreach($three_section as $k=>$v){ ?>
                    <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $section) echo 'selected'; ?>><?php echo $v['name'];?></option>
                    <?php }} ?>
                </select>
                <span style="color:red;" id="errorSection"></span>
            </td>
    	</tr>
    	<tr>
      		<td class="left_title_2"><span style='color:red'>*</span>&nbsp;所属关键词</td>
      		<td>
      			<select name="keyword" id="keyword">
                	<option value="0">-- 选择关键词 --</option>
                    <?php if(!empty($keywords)) {foreach($keywords as $k=>$v) {?>
                    <option value="<?php echo $v['id']?>" <?php if($v['id'] == $keyword) echo 'selected' ;?>><?php echo $v['name'];?></option>
                    <?php }} ?>
                </select>
                <span style="color:red;" id="errorKeyword"></span>
      		</td>
    	</tr>
    	<tr>
      		<td width="18%" class="left_title_1"><span style='color:red'>*</span>&nbsp;标题</td>
            <td width="82%"><input class="text_style" type="text" name="title" id="title" value="<?php echo $title;?>" /> <span style="color:red;" id="errorTitle"></span></td>
    	</tr>
    	<tr>
      		<td class="left_title_2">副标题</td>
            <td><input class="text_style" type="text" name="subtitle" value="<?php echo $subtitle;?>" /></td>
    	</tr>
    	<tr>
    		<td class="left_title_1">文章来源</td>
            <td><input type="text" name="source"  value="<?php echo $source;?>" /></td>
    	</tr>
        <tr>
    		<td class="left_title_2">相关标签</td>
    		<td>
                <div id="my_tag" class="my_tag clearfloat">
                    <button onclick="show_div()" type="button">添加标签</button>
                </div>
            </td>
    	</tr>
    	<tr>
      		<td class="left_title_2">文章内容</td>
      		<td> <?php echo $kindeditor;?></td>

    	</tr>
        <!--
    	<tr>
      		<td class="left_title_1">文章状态</td>
      		<td>
      			<input type="radio" name="status" value="2" checked="checked" />待审核	&nbsp;&nbsp;
      			<input type="radio" name="status" value="1" />审核通过 &nbsp;&nbsp;
      			<input type="radio" name="status" value="0" />禁用	&nbsp;&nbsp;
      		</td>
    	</tr>
    	<tr>
      		<td class="left_title_2">文章优先</td>
      		<td>
      			<input type="checkbox" name="top" value="1" />置顶文章  &nbsp;&nbsp;
      			<input type="checkbox" name="recommend" value="1" />推荐文章  &nbsp;&nbsp;
      		</td>
    	</tr>
        <tr>
        	<td class="left_title_1">点击量</td>
            <td><input class="text_style" type="text" name="click" value="{$click}" style="width:66px;"></td>
        </tr>       
        -->
        <tr>
      		<td class="left_title_2">&nbsp;<input type="hidden" name='section' id='section' value='' /></td>
      		<td><input type="submit" name="submit" value=" 提交 " />&nbsp;&nbsp;
            <input type="reset" name="reset" value=" 重置 " />
            </td>
    	</tr>
  	</table>
    </form>
    <br />
    <br /><br />
</div>
<script type="text/javascript" src="/adminStatic/js/jquery.js" ></script>
<script type="text/javascript" src="/adminStatic/js/common.js" ></script>
<?php
$this->load->helper('admin');
relation_tag($id, 1, $tagNameArr);
?>
<script type="text/javascript">
function check_form()
{
    var one = $("#one").val();
    var two = $("#two").val();
    var three = $("#three").val();
    var keyword = $("#keyword").val();
    if(0!=three)
    {
        section = three;
    }else if(0!=two)
    {
        section = two;
    }else if(0!=one)
    {
        section = one;
    }
    $("#section").val(section);
    var section = $("#section").val();
    var title = $("#title").val();
    if(title != '' && section != 0 &&  keyword != 0)
    {
        return true;
    }else
    {
        if(0==section)
        {
            $("#errorSection").html('文章所属栏目不能为空！');
        }else if(0==keyword)
        {
            $("#errorKeyword").html('关键词不能为空！');
        }else
        { 
            $("#errorTitle").html('文章栏目不能为空！');
        }
        return false;
    }

}
</script>
</body>
</html>
