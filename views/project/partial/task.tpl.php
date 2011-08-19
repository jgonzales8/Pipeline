<?php
include_once TEMPLATE_PATH.'/site/helper/format.php';

$task = $SOUP->get('task');
$project = $SOUP->get('project');
$token = Upload::generateToken();
$uploads = $SOUP->get('uploads');
$numComments = $SOUP->get('numComments', 0);

$fork = $SOUP->fork();
$fork->startBlockSet('body');
$fork->set('editable', true);
$fork->set('editLabel', 'Edit Task');
//$fork->set('title', 'Task Info');

?>

<div class="view">


<div class="person-box">
	<a class="picture large" href="<?= Url::user($task->getLeaderID()) ?>"><img src="<?= Url::userPictureLarge($task->getLeaderID()) ?>" /></a>
	<div class="text">
		<p class="caption">task leader</p>
		<p class="username"><?= formatUserLink($task->getLeaderID()) ?></p>
	</div>
</div>

<h5><?= $task->getTitle() ?></h5>

<?php $class = ($task->getStatus() == Task::STATUS_OPEN) ? 'good' : 'bad';	?>
<p><span class="<?= $class ?>"><?= Task::getStatusName($task->getStatus()) ?></span> <span class="slash">/</span> <?= ($task->getDeadline() != '') ? 'due '.formatTimeTag($task->getDeadline()) : 'no deadline' ?><!-- <span class="slash">/</span> <?= ($task->getNumNeeded() != '') ? formatCount($task->getNumNeeded(),'person','people','no').' needed' : '(none)' ?> --></p>



<div class="line"></div>



<p><?= formatTaskDescription($task->getDescription()) ?></p>

<?php
	$SOUP->render('site/partial/newUploads', array(
		'uploads' => $uploads
	));
?>
<!--
<script type="text/javascript">

$(document).ready(function(){
	$('#btnShowComments').mousedown(function(){
		$(this).parent().remove();
		$('#comments').fadeIn();
	});
});

</script>

<div class="buttons">
	<input class="right" type="button" id="btnShowComments" value="Comments (<?= $numComments ?>)" />
</div>
-->

</div><!-- end .view -->


<div class="edit hidden">

<script type="text/javascript">
$(document).ready(function(){
	$("#txtDeadline").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd' // MySQL datetime format
	});
	$('#selStatus').val('<?= $task->getStatus() ?>');
	$('#btnEditTask').click(function(){
		buildPost({
			'processPage':'<?= Url::taskProcess($task->getID()) ?>',
			'info':{
				'action': 'edit',
				'token':'<?= $token ?>',
				'title': $('#txtTitle').val(),
				'leaderID': $('#txtLeader').val(),
				'description': $('#txtDescription').val(),
				'status': $('#selStatus').val(),
				'numNeeded': $('#txtNumNeeded').val(),
				'deadline': $('#txtDeadline').val()
			},
			'buttonID':'#btnEditTask'
		});
	});
	
	$("#btnCancelTask").mousedown(function(){
		$("#task .edit").hide();
		$("#task .view").fadeIn();
	});
	$("#task .editButton").click(function(){
		var edit = $("#task .edit");
		var view = $("#task .view");
		toggleEditView(edit, view);
		if($(view).is(":hidden"))
			$('#txtTitle').focus();
	});		
});
</script>

<div class="clear">
	<label for="txtTitle">Task Name<span class="required">*</span></label>
	<div class="input">
		<input id="txtTitle" type="text" maxlength="255" value="<?= $task->getTitle() ?>" />
		<p>Short description of this task</p>
	</div>
</div>

<div class="clear">
	<label for="txtLeader">Leader<span class="required">*</span></label>
	<div class="input">
		<input id="txtLeader" type="text" value="<?= $task->getLeaderID() ?>" />
		<p>An organizer to lead this task</p>
	</div>
</div>

<div class="clear">
	<label for="txtDescription">Instructions<span class="required">*</span></label>
	<div class="input">
		<textarea id="txtDescription"><?= $task->getDescription() ?></textarea>
	</div>
</div>

<div class="clear">
	<label for="selStatus">Status<span class="required">*</span></label>
	<div class="input">
		<select id="selStatus">
			<option value="<?= Task::STATUS_OPEN ?>"><?= Task::getStatusName(Task::STATUS_OPEN) ?></option>
			<option value="<?= Task::STATUS_CLOSED ?>"><?= Task::getStatusName(Task::STATUS_CLOSED) ?></option>
		</select>
	</div>
</div>

<div class="clear">
	<label for="txtNumNeeded"># People Needed</label>
	<div class="input">
		<input id="txtNumNeeded" type="text" value="<?= $task->getNumNeeded() ?>" />
		<p>Number of people needed for this task<br />
		(Leave empty for unlimited)</p>
	</div>
</div>

<div class="clear">
	<label for="txtDeadline">Deadline</label>
	<div class="input">
		<input id="txtDeadline" type="text" value="<?= ($task->getDeadline() != '') ? date("Y-m-d",strtotime($task->getDeadline())) : '' ?>" />
	</div>
</div>

<div class="clear">
	<label>Uploads</label>
	<div class="input">
		
	<?php
		$SOUP->render('site/partial/upload', array(
			'token' => $token,
			'item_type' => Upload::TYPE_TASK,
			'item_id' => $task->getID()
		));
	?>
		
	</div>
</div>

<div class="clear">
	<div class="input">
		<input id="btnEditTask" type="button" value="Save" />
		<input id="btnCancelTask" class="right" type="button" value="Cancel" />
	</div>
</div>

</div><!-- end .edit -->



<?php

$fork->endBlockSet();
$fork->render('site/partial/panel');