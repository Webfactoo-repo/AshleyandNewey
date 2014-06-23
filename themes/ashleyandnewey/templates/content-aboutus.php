<div id="slider-page">
    <div id="img-slider">
        <?php
            echo get_new_royalslider(1);
        ?>
    </div>
    <div id="content-slider">
        <div id="content-slider-bg-holder">
        <?php
            echo get_new_royalslider(3);
        ?>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    setTimeout(function() {
	var slider = $(".new-royalslider-1").data('royalSlider');
        var content = $(".new-royalslider-3").data('royalSlider');
        slider.ev.on('rsBeforeMove', function(event, type, userAction ) {
            if(type === "next"){
                content.next();
            }else if(type === "prev"){
                content.prev();
            }else{
                content.goTo(type);
            }  
        });
    }, 1);
});
</script>