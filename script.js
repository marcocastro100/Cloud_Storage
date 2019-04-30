function anima_click($this){
    $($this).append("  <div class='spinner-border text-dark' id='animacao' style='width:15px;height:15px'> </div>");
    setTimeout(function(){
        $('#animacao').remove();
    }, 500);
}