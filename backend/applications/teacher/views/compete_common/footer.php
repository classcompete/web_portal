<?php /*
<div class="feedback-wrapper">
    <a href="http://www.classcompete.com/pilots/" target="_blank" class="btn btn-block btn-info feedback-subwrapper">
        <div class="feedback">Feedback</div>
    </a>
</div>
 */?>

<footer>
    <p>
        &copy; Class Compete <?php echo date("Y") ?> |
        <a class="footer-links" href="http://www.classcompete.com/privacy" target="_blank">Privacy Policy</a><span> | </span>
        <a class="footer-links" href="http://www.classcompete.com/terms" target="_blank">Terms of Services</a><span> | </span>
    </p>
</footer>

<!--<script src="--><?php //echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/plupload.browserplus.js') ?><!--"></script>-->
<!--<script src="--><?php //echo AssetHelper::jsUrl('../../vendor/plupload/plupload.flash.js') ?><!--"></script>-->
<!--<script src="--><?php //echo AssetHelper::jsUrl('../../vendor/plupload/plupload.gears.js') ?><!--"></script>-->
<!--<script src="--><?php //echo AssetHelper::jsUrl('../../vendor/plupload/plupload.html5.js') ?><!--"></script>-->
<!--<script src="--><?php //echo AssetHelper::jsUrl('../../vendor/plupload/plupload.html4.js') ?><!--"></script>-->

<!-- Google Visualization JS -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- Easy Pie Chart JS -->
<script src="<?php echo AssetHelper::jsUrl('jquery.easy-pie-chart.js') ?>"></script>

<!-- Sparkline JS -->
<script src="<?php echo AssetHelper::jsUrl('jquery.sparkline.js') ?>"></script>

<!-- Tiny Scrollbar JS -->



<script type="text/javascript">
//ScrollUp
$(function () {
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        topDistance: '300', // Distance from top before showing element (px)
        topSpeed: 300, // Speed back to top (ms)
        animation: 'fade', // Fade, slide, none
        animationInSpeed: 400, // Animation in speed (ms)
        animationOutSpeed: 400, // Animation out speed (ms)
        scrollText: 'Scroll to top', // Text for element
        activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    });
});

//Tooltip
$('a').tooltip('hide');
$('i').tooltip('hide');


//Tiny Scrollbar



//Tabs
$('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
})


//wysihtml5
$('#wysiwyg').wysihtml5();
</script>

<div id="loading_spinner" style="display: none"></div>
</body>
</html>