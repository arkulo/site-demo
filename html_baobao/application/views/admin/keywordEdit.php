<?php $this->load->view('admin/header',$this->_info)?>
<body>
<div id="man_zone">
    <?php $this->load->view('admin/editNav',$this->_info)?>
    <?php echo form_open(site_url('admin/keyword/saveEdit/'.$id), array('class'=>"jnice","onsubmit"=>"return check_form()"));?>
    <?php $this->load->view('admin/editTable')?>
    	<tr>
      		<td><span style='color:red'>*</span>&nbsp;所属栏目</td>
      		<td>
      			<select name="one" id="one" onchange="changeOn('one',this.value)">
                	<option value="0">-- 请选择 --</option>
                    <?php if(!empty($one_section)) {foreach($one_section as $k=>$v) {?>
                    <option value="<?php echo $v['id']?>" <?php if($one != '' && $one['id'] == $v['id']){ echo 'selected';}?> style="background-color:#FFC;"><?php echo $v['name']?></option>
                    <?php }} ?>
                </select>
                <select style="display:inline;" name="two" id="two" onchange="changeOn('two',this.value)">
                    <option value='0'>-- 请选择 --</option>
                    <?php if($two_section != ''){ foreach($two_section as $k=>$v){ ?>
                    <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $two['id']) echo 'selected'; ?>><?php echo $v['name'];?></option>
                    <?php }} ?>
                </select>
                <select style="display:inline;" name="three" id="three" onchange="changeOn('three',this.value)">
                    <option value='0'>-- 请选择 --</option>
                    <?php if($three_section != ''){ foreach($three_section as $k=>$v){ ?>
                    <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $section) echo 'selected'; ?>><?php echo $v['name'];?></option>
                    <?php }} ?>
                </select>
                <span style="color:red;" id="errorSection"></span>
            </td>
    	</tr>
    	<tr>
      		<td width="18%"><span style='color:red'>*</span>&nbsp;名称</td>
            <td width="82%"><input class="text_style" type="text" name="name" id="name" value="<?php echo $name;?>" /> <span style="color:red;" id="errorTitle"></span></td>
    	</tr>
        <tr>
      		<td> <input type="hidden" name='section' id='section' value='' /></td>
      		<td><?php $this->laod->view('admin/editSubmit',$this->_info)?></td>
    	</tr>
  	</table>
    </form>
</div>
<?php $this->load->view('admin/common',$this->_info);?>
<script type="text/javascript">
function check_form()
{
    var one = $("#one").val();
    var two = $("#two").val();
    var three = $("#three").val();
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
    var name = $("#name").val();
    if(name != '' && section != 0)
    {
        return true;
    }else
    {
        if(0==section)
        {
            $("#errorSection").html('关键词所属栏目不能为空！');
        }else
        { 
            $("#errorTitle").html('关键词名称不能为空！');
        }
        return false;
    }

}
</script>
</body>
</html>
