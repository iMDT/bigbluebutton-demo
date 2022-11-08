<?php
$roomName = $_POST['room-name'] ?? null;
$userName = $_POST['user-name'] ?? null;
$userRole = $_POST['user-role'] ?? null;
$submit = !empty($_POST['submit'] ?? null);

// complete post (join BBB)
if( !empty($roomName) && !empty($userName) && !empty($userRole)) {
	$bbbUrl = getenv('BIGBLUEBUTTON_URL');
	$bbbSecret = getenv('BIGBLUEBUTTON_SECRET');

	// Create meeting
	$createParametersForHash = 'meetingID='.$roomName.'&name='.$roomName.$bbbSecret;
	$createChecksum = hash('sha256', 'create'.$createParametersForHash);

        $createParametersForCall = 'meetingID='.urlencode($roomName).'&name='.urlencode($roomName);
	$createCall = $bbbUrl . 'api/create?' . $createParametersForCall . '&checksum='.$createChecksum;

	$createResponse = @file_get_contents($createCall);
	if(strpos($createResponse, 'SUCCESS')===FALSE && strpos($createResponse, 'already exists with')===FALSE){
		die('Failed to create meeting: <pre>' . htmlentities($createResponse) . '</pre>');
	}


	// Join meeting
	$joinParametersForHash = 'fullName='.$userName.'&meetingID='.$roomName.'&role='.$userRole.$bbbSecret;
	$joinChecksum = hash('sha256', 'join'.$joinParametersForHash);

	$joinParametersForCall = 'fullName='.urlencode($userName).'&meetingID='.urlencode($roomName).'&role='.urlencode($userRole);
	$joinCall = $bbbUrl . 'api/join?' . $joinParametersForCall . '&checksum='.$joinChecksum;

	header('Location: '.$joinCall);
	die();
}

if(empty($roomName)) {
	$roomName='bbb-' . rand(1000, 9999);
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>
.required {
    color: #d00;
}

button {
  margin-top: 1rem;
  background-color: #0F4D9D !important;
  border-color: white !important;
}
</style>
</head>
<body>
  <div class="d-flex justify-content-center">
    <div class="d-flex flex-column w-25">
      <img src="images/bbb-logo.png" />

      <form method="POST" action="#">
        <!-- Room name input -->
        <div class="form-ooutline mb-4">
          <label class="form-label" for="room-name">Room name</label>
          <input type="text" minlength="3" name="room-name" id="room-name" class="form-control" value="<?php echo htmlentities($roomName??'') ?>" />
          <?php if($submit && empty($roomName)) { ?> <span class="required">required</span> <?php } ?>
        </div>

        <!-- User name input -->
        <div class="form-outline mb-4">
          <label class="form-label" for="user-name">Your name</label>
          <input type="text" minlength="3" name="user-name" id="user-name" class="form-control" value="<?php echo htmlentities($userName??'') ?>" />
          <?php if($submit && empty($userName)) { ?> <span class="required">required</span> <?php } ?>
        </div>

        <!-- Role input -->
        <div class="form-outline mb-4">
          Role
          <input class="form-check-input" type="radio" name="user-role" id="user-role-moderator" value="moderator" checked="checked">
          <label class="form-check-label" for="user-role-moderator">
            Moderator
          </label>
          <input class="form-check-input" type="radio" name="user-role" id="user-role-viewer" value="viewer">
          <label class="form-check-label" for="user-role-viewer">
            Viewer
          </label>
        </div>

        <!-- Submit button -->
        <button type="submit" value="submit" name="submit" class="btn btn-primary btn-block w-100">Join</button>

      </form>
    </div>
  </div>
</body>
