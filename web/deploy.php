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
    'git pull'
);


// Run the commands for output
$output = '';
foreach ($commands AS $command) {
    // Run it
    $tmp = shell_exec($command);
    // Output
    $output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
    $output .= htmlentities(trim($tmp)) . "\n";
}
function rrmdir($dir) {
    if (@is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        @rmdir($dir);
    }
}
rrmdir(__DIR__.'/../app/cache/prod');
// Make it pretty for manual user access (and why not?)
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
    <pre>


        <?php echo $output; ?>
    </pre>
</body>
</html>


