<footer>
    <p>
        &copy; Class Compete 2013 |
        <a class="footer-links" href="http://www.classcompete.com/privacy" target="_blank">Privacy Policy</a><span> | </span>
        <a class="footer-links" href="http://www.classcompete.com/terms" target="_blank">Terms of Services</a><span> | </span>
    </p>
</footer>

<script src="<?php echo AssetHelper::jsUrl('wysiwyg/wysihtml5-0.3.0.js') ?>"></script>

<script src="<?php echo AssetHelper::jsUrl('bootstrap.js') ?>"></script>
<script src="<?php echo AssetHelper::jsUrl('wysiwyg/bootstrap-wysihtml5.js') ?>"></script>
<script src="<?php echo AssetHelper::jsUrl('jquery.scrollUp.js') ?>"></script>
<script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload/jquery.plupload.queue/jquery.plupload.queue.js') ?>"></script>
<script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload/plupload.full.js') ?>"></script>
<script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload/jquery.ui.plupload/jquery.ui.plupload.js') ?>"></script>


<!-- Google Visualization JS -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- Easy Pie Chart JS -->
<script src="<?php echo AssetHelper::jsUrl('jquery.easy-pie-chart.js') ?>"></script>

<!-- Sparkline JS -->
<script src="<?php echo AssetHelper::jsUrl('jquery.sparkline.js') ?>"></script>

<!-- Tiny Scrollbar JS -->
<script src="<?php echo AssetHelper::jsUrl('tiny-scrollbar.js') ?>"></script>


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
$('#scrollbar').tinyscrollbar();
$('#scrollbar-one').tinyscrollbar();
$('#scrollbar-two').tinyscrollbar();
$('#scrollbar-three').tinyscrollbar();


//Tabs
$('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
})

// SparkLine Graphs-Charts
$(function () {
    $('#unique-visitors').sparkline('html', {
        type: 'bar',
        barColor: '#ed6d49',
        barWidth: 6,
        height: 30
    });
    $('#monthly-sales').sparkline('html', {
        type: 'bar',
        barColor: '#74b749',
        barWidth: 6,
        height: 30
    });
    $('#current-balance').sparkline('html', {
        type: 'bar',
        barColor: '#ffb400',
        barWidth: 6,
        height: 30
    });
    $('#registrations').sparkline('html', {
        type: 'bar',
        barColor: '#0daed3',
        barWidth: 6,
        height: 30
    });
    $('#site-visits').sparkline('html', {
        type: 'bar',
        barColor: '#f63131',
        barWidth: 6,
        height: 30
    });
});

//wysihtml5
$('#wysiwyg').wysihtml5();
</script>

</body>
</html>