<div id="slider-page" class="conact-us">
    <div id="img-slider">
        <?php
            echo get_new_royalslider(2);
        ?>
    </div>
    <div id="content-slider">
        <div id="content-slider-bg-holder">
        <?php
            echo get_new_royalslider(5);
        ?>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    setTimeout(function() {
	var slider = $(".new-royalslider-2").data('royalSlider');
        var content = $(".new-royalslider-5").data('royalSlider');
        slider.ev.on('rsBeforeMove', function(event, type, userAction ) {
            if(type == "next"){
                if(slider.currSlideId == 2){
                    $("#content-slider").css({"display": "none"});
                }else{
                    $("#content-slider").css({"display": "block"});
                }
                content.next();
            }else if(type == "prev"){
                content.prev();
                console.log(slider.currSlideId);
                if(slider.currSlideId !== 1){
                    $("#content-slider").show();
                }else{
                    $("#content-slider").hide();
                }
            }else{
                content.goTo(type);
                if(type !== 0){
                    $("#content-slider").show();
                }else{
                    $("#content-slider").hide();
                }
            }
        });
    }, 1);
});
</script>