<?php 

    function getEmailTemplate($toEmail,$bodyMessage,$fromEmail,$subject) {

          $emailContent = '<link rel="stylesheet" href= "email_templates_styles.css"><div class="container header">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <center><h1>Email</h1></center>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <center><img src="http://192.168.0.115/open_library/uploads/logo/logo.png" class="logo-responsive"></center>
                </div>
            </div>
        </div>
        <div class="container content">
            '.$bodyMessage.'
        </div>
        <div class="container footer">
            <center><p>©2015-2017 All Rights Reserved.</p></center>
        </div>';
        echo $emailContent; die;
          // Always set content-type when sending HTML email
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

          // More headers
          $headers .= "From: <".$fromEmail.">" . "\r\n";
          // $headers .= 'Cc: myboss@example.com' . "\r\n";

          mail($toEmail,$subject,$emailContent,$headers);
    }

?>