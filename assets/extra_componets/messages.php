<div class="container_messages">

     
<!--mensajes de todo ok-->
<?php if(isset($message_check)):?>
    <?php foreach($message_check as $message_check):?>
            <div class="message message_check">
                <i class="fas fa-check"></i>
                <span><?php echo $message_check;?></span>
            </div>
    <?php endforeach;?>
<?php endif;?>


<!--mensajes de error-->
<?php if(isset($message_times)):?>
    <?php foreach($message_times as $message_times):?>
            <div class="message message_times">
                <i class="fas fa-times"></i>
                <span><?php echo $message_times;?></span>
            </div>
    <?php endforeach;?>
<?php endif;?>



<!--mensajes de alerta-->
<?php if(isset($message_alert)):?>
    <?php foreach($message_alert as $message_alert):?>
            <div class="message message_alert">
                <i class="fas fa-exclamation"></i>
                <span><?php echo $message_alert;?></span>
            </div>
    <?php endforeach;?>
<?php endif;?>


<!--mensajes de error-->
<?php if(isset($message_error)):?>
    <?php foreach($message_error as $message_error):?>
            <div class="message message_times">
                <i class="fas fa-times"></i>
                <span><?php echo $message_error;?></span>
            </div>
    <?php endforeach;?>
<?php endif;?>

</div>