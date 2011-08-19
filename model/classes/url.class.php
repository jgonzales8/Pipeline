<?php

class Url
{
	public static function base()
	{
		return BASE_URI;
	}
	
	public static function error() {
		return (self::base().'/error');
	}
	
	public static function uploads()
	{
		return (self::base().'/up');
	}
	
	public static function uploadProcess()
	{
		return (self::base().'/upload/process');
	}	
	
	public static function download($fileID=null) {
		if($fileID == null) return null;
		return (self::base().'/download/'.$fileID);
	}
	
	public static function thumb() {
		return (self::uploads().'/th');
	}
	
	public static function preview() {
		return (self::uploads().'/pr');
	}
	
	public static function images()
	{
		return (self::base().'/images');
	}
	
	public static function scripts()
	{
		return (self::base().'/scripts');
	}
	
	public static function styles()
	{
		return (self::base().'/styles');
	}	
	
	public static function home()
	{
		return self::base();
	}
	
	public static function dashboard()
	{
		return self::base();
	}
	
	public static function findProjects()
	{
		return (self::base().'/projects');
	}
	
	public static function startAProject()
	{
		return (self::base().'/projects/start');
	}
	
	public static function register()
	{
		return (self::base().'/register');
	}
	
	public static function registerProcess()
	{
		return (self::register().'/process');
	}
	
	public static function consent()
	{
		return (self::base().'/consent');
	}
	
	public static function consentProcess()
	{
		return (self::consent().'/process');
	}
	
	public static function adultConsent()
	{
		return (self::consent().'/adult');
	}
	
	public static function minorConsent()
	{
		return (self::consent().'/minor');
	}
	
	public static function logIn()
	{
		return (self::base().'/login');
	}
	
	public static function logInProcess()
	{
		return (self::logIn().'/process');
	}
	
	public static function logOut()
	{
		return (self::base().'/logout');
	}
	
	public static function inbox()
	{
		return (self::base().'/inbox');
	}
	
	public static function profile()
	{
		$userID = Session::getUserID();
		return (self::user($userID));
	}
	
	public static function user($userID=null)
	{
		if($userID == null) return null;
		$user = User::load($userID);
		$username = $user->getUsername();
		$url = self::base().'/users/'.$username;
		return $url;
	}
	
	public static function userPictureSmall($userID=null)
	{
		if($userID == null) return null;
		$user = User::load($userID);
		if($user->getPictureSmall() != '')
			$url = self::uploadsDir().'/thumb/'.$user->getPictureSmall();
		else
			$url = self::images().'/user_48x48.jpg';
		return $url;
	}
	
	public static function userPictureLarge($userID=null)
	{
		if($userID == null) return null;
		$user = User::load($userID);
		if($user->getPictureLarge() != '')
			$url = self::uploadsDir().'/thumb/'.$user->getPictureLarge();
		else
			$url = self::images().'/user_48x48.jpg';
		return $url;
	}	
	
	public static function project($projectID=null)
	{
		if($projectID == null) return null;
		$project = Project::load($projectID);
		$slug = $project->getSlug();
		return (self::base().'/projects/'.$slug);
	}
	
	public static function activity($projectID=null)
	{
		if($projectID == null) return null;
		return (self::project($projectID).'/activity');
	}
	
	public static function activityDetails($projectID=null)
	{
		if($projectID == null) return null;
		return (self::activity($projectID).'/details');
	}		
	
	public static function activityTasks($projectID=null)
	{
		if($projectID == null) return null;
		return (self::activity($projectID).'/tasks');
	}
	
	public static function activityDiscussions($projectID=null)
	{
		if($projectID == null) return null;
		return (self::activity($projectID).'/discussions');
	}

	public static function activityPeople($projectID=null)
	{
		if($projectID == null) return null;
		return (self::activity($projectID).'/people');
	}

	public static function details($projectID=null)
	{
		if($projectID == null) return null;
		return (self::project($projectID).'/basics');
	}
	
	public static function pitch($projectID=null)
	{
		if($projectID == null) return null;
		return (self::details($projectID).'#pitch');
	}
	
	public static function specs($projectID=null)
	{
		if($projectID == null) return null;
		return (self::details($projectID).'#specs');
	}	
	
	public static function rules($projectID=null)
	{
		if($projectID == null) return null;
		return (self::details($projectID).'#rules');
	}	
	
	public static function detailsProcess($projectID=null)
	{
		if($projectID == null) return null;
		return (self::details($projectID).'/process');
	}

	public static function tasks($projectID=null)
	{
		if($projectID == null) return null;
		return (self::project($projectID).'/tasks');
	}
	
	public static function task($taskID=null)
	{
		if($taskID == null) return null;
		$task = Task::load($taskID);
		return (self::tasks($task->getProjectID()).'/'.$taskID);
	}
	
	public static function taskProcess($taskID=null) {
		if($taskID == null) return null;
		return (self::task($taskID).'/process');
	}
	
	public static function taskNew($projectID=null)
	{
		if($projectID == null) return null;
		return (self::tasks($projectID).'/new');
	}
	
	public static function taskNewProcess($projectID=null) {
		if($projectID == null) return null;
		return (self::taskNew($projectID).'/process');
	}
	
	
	// public static function updates($acceptedID=null)
	// {
		// if($acceptedID == null) return null;
		// $accepted = Accepted::load($acceptedID);
		// $creator = User::load($accepted->getCreatorID());
		// return (self::task($accepted->getTaskID()).'/'.$creator->getUsername());
	// }
	
	public static function update($updateID=null)
	{
		if($updateID == null) return null;
		$update = Update::load($updateID);
		$accepted = Accepted::load($update->getAcceptedID());
		return (self::task($accepted->getTaskID()).'/updates/'.$updateID);
	}
	
	public static function updateProcess($updateID=null) {
		if($updateID == null) return null;
		return (self::update($updateID).'/process');
	}
	
	public static function updateNew($taskID=null) {
		if($taskID == null) return null;
		return (self::task($taskID).'/updates/new');
	}
	
	public static function updateNewProcess($taskID=null) {
		if($taskID == null) return null;
		return (self::updateNew($taskID).'/process');
	}
	
	public static function discussions($projectID=null)
	{
		if($projectID == null) return null;
		return (self::project($projectID).'/discussions');
	}
	
	public static function discussion($discussionID=null)
	{
		if($discussionID == null) return null;
		$discussion = Discussion::load($discussionID);
		return (self::discussions($discussion->getProjectID()).'/'.$discussionID);
	}
	
	public static function discussionProcess($discussionID=null)
	{
		if($discussionID == null) return null;
		return (self::discussion($discussionID).'/process');
	}
	
	public static function discussionNew($projectID=null) {
		if($projectID == null) return null;
		return (self::discussions($projectID).'/new');
	}
	
	public static function discussionNewProcess($projectID=null) {
		if($projectID == null) return null;
		return (self::discussionNew($projectID).'/process');
	}

	public static function people($projectID=null)
	{
		if($projectID == null) return null;
		return (self::project($projectID).'/people');
	}
	
	public static function banned($projectID=null)
	{
		if($projectID == null) return null;
		return (self::people($projectID).'/banned');
	}
	
}