<?php
$key  = '12698kxnopqw55498321zxoidqwnnsac';
if($_REQUEST['api_key'] != $key){
    exit;
}
/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying websites via github or bitbucket, more deets here:
 *
 *        https://gist.github.com/1809044
 */

// The commands
$commands = array(
    'echo $PWD',
    'whoami',
    'git pull',
    sprintf('sh %s/../build_sf.sh',__DIR__)
);

// Run the commands for output
$output = '';
$output .= '=================='.date('Y-m-d H:i:s').'============================'."\n";
foreach ($commands AS $command) {
    // Run it
    $tmp = shell_exec($command);
    // Output
    $output .= '---------------------------------------------'."\n";
    $output .= '$ '.$command."\n";
    $output .= htmlentities(trim($tmp)) . "\n\n";
}
$output .= "==============================================\n\n";
file_put_contents(__DIR__.'/deploy.log',$output);
?>



