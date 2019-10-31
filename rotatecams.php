<?php
$seconds=$_GET[seconds];
if (!$_GET[seconds]) { $seconds="30"; }
$seconds=$seconds*1000;
?>
	<script>
                $(document).ready(function() {
                    rotate();
                    setInterval(rotate, <?php echo "$seconds"; ?>);
                });

                function rotate() {
                    $.ajax({
                        url: 'rotate.php',
                        success: function(data) {
                            $('#rotatecam').html(data);
                        },
                    });
                }
        </script>
	<span id="rotatecam"></span>

