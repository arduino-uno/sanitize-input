<?php
error_reporting(0);
$input = $_GET['user_input'];

if ( isset( $input ) ) {
    
    if ( check_input( $input ) ) {

        $result = sanitize_input( $input );
        
        $message = "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Warning!</strong>&nbsp;Detected SQL Injection Code:&nbsp;<span style='background-color:#333;color:#fff;font-size:20px'>&nbsp;{$result}&nbsp;</span>.
        </div>";
        
    } else {

        $message = "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Success!</strong>&nbsp;This page is secured from sql injection attacks.</span>.
        </div>";
        
    };

};

function sanitize_input( $input = null ) {
    
    // Change input to uppercase
    $input = strtoupper( $input );

    // Array SQLi codes
    $sqli_codes = array('OR',
            'AND',
            'ORDER',
            'BY',
            'NULL',
            'ALL',
            'SELECT',
            'FROM',
            'WHERE',
            'UNION',
            '[-+=*\'\"]' // filter any special chars eg: quote & double quotes
        );
    
    // converts the array into a regex friendly or list
    $sqli_code = implode('|', $sqli_codes);
    $result = preg_match('/' . $sqli_code . '/', $input, $matches);

    return $matches[0];

};

function check_input( $input = null ) {

    $result = sanitize_input( $input );

    if ( strlen( $result ) > 0 ) {
        return TRUE;
    } else {
        return FALSE;
    };

};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SQL Injection Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div><h1>Sanitize input&nbsp;<small>( Sanitize the input text from the malicious code ).</small></h1></div>
    <div class="row-fluid">        
        <div class="span6">
            <?php echo $message; ?>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="user_input">User input:</label>
                    <input type="text" class="form-control input-lg" id="user_input" placeholder="Please enter whatever text. eg: ' OR 1=1 --" name="user_input" size="20">
                </div>
                <button type="submit" name="send" class="btn btn-primary">send</button>
            </form>
        </div>
        <div class="span6">&nbsp;</div>
    </div>
</div>
</body>
</html>