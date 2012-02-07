<?php
	require_once dirname(__FILE__) . "/../common/config/config.php";
	
?>

<html>
	<head>
		<script type="text/javascript" src="js/jquery.js"></script>
		<title>
			Incredible Chess Tournament -- by Mihailo Joksimovic
		</title>
		
		<style type="text/css">
			label
			{
				width: 150px;
				display: inline-block;
			}
		</style>
	</head>
	
	<body>
		
		
		
		<div style="width:800px; min-height: 200px; margin: 0 auto; margin-top: 5%; border: 1px solid black;">
			<div style="text-align: center;">
				<h2>
					Start New Game
				</h2>
			</div>
			
			
			<?php
				$errors	= array();
				
				if ( ! empty($_POST))
				{
					unset($_SESSION['game']);
					
					if ( ! isset($_POST['game_type']) ||  ! in_array($_POST['game_type'], array(1, 2)))
					{
						$errors[]	= "Please, select a Game Type";
					}
					
//					if ($_POST['wtime'] < 0)
//					{
//						$errors[]	= "Invalid time limit for white player ! Valid is > 0";
//					}
//					
//					if ($_POST['btime'] < 0)
//					{
//						$errors[]	= "Invalid time limit for black player ! Valid is > 0";
//					}
					
					if (empty($errors))
					{
						$_SESSION['game_type']	= $_POST['game_type'];
						$_SESSION['wtime']		= $_POST['wtime'];
						$_SESSION['btime']		= $_POST['btime'];
						$_SESSION['ai_skill']		= $_POST['skill'];
						
						header("Location: share_screen.php");
						
						exit(0);
					}
				}

			?>
			
			
			<?php if ( ! empty($errors)): ?>
			<?php foreach ($errors AS $error): ?>
			<p style="color: red;">
				<?php echo $error ?><br/>	
			</p>
			
			<?php endforeach; ?>
			<?php endif; ?>
			
			
			<form name="new_game" method="POST" action="">
				<label>
					Game Type:
				</label>
				
				<select name="game_type" onchange="if($(this).val() == 2) { $('#ai_skill').show(); } else { $('#ai_skill').hide(); }">
					<option value="0">Game Type</option>
					<option value="1">Player VS Player</option>
					<option value="2">Player VS Computer</option>
				</select>
				
				<div id="ai_skill" style="display:none;">
					<label>Computer Skill: </label>

					<select name="skill">
						<option value="1">Dumb</option>
						<option value="5">Easy</option>
						<option value="10">Medium</option>
						<option value="15">Hard</option>
						<option value="20">Brutal</option>
					</select>
				</div>
				<br/>
				
				<!--
				
				<h3>Time Limits</h3>
				
				<label>White player:</label>
				<input type="text" name="wtime" value="0" size="3"/> min.
				
				<br/>
				
				<label>Black player:</label>
				<input type="text" name="btime" value="0" size="3" /> min.
				-->
				
				<br/>
				<br/>
				
				<button type="submit">Start new game !</button>
			</form>
		</div>
		
	</body>
</html>