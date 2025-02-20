<?php

function AlertaExitosa($mensaje)
{
?>
    <script>
        alertify.set('notifier', 'position', 'top-right');
        alertify.success('<?php echo $mensaje; ?>');
    </script>
<?php
}

function AlertaError($mensaje)
{
?>
    <script>
        alertify.set('notifier', 'position', 'top-right');
        alertify.error('<?php echo $mensaje; ?>');
    </script>
<?php
}

function AlertaAdvertencia($mensaje)
{
?>
    <script>
        alertify.set('notifier', 'position', 'top-center');
        alertify.warning('<?php echo $mensaje; ?>');
    </script>
<?php
}




