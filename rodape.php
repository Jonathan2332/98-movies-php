<script type="text/javascript">
	
window.onscroll = function() {scrollFunction()};

function checkBackground(color)
{
    var user = '<?php echo $_SESSION['usuario']['idPerfil']; ?>';
    var navbar = $("#navbar");
    var button = $("#button-search");
    var isExpanded = $("#button-toggle").attr("aria-expanded");
    if(isExpanded == "true")
    {
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) 
        {
            navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            navbar.css("background-color", user == 2 ? "red" : "rgb(92,184,92)");
            button.attr("class", "btn btn-outline-light my-2 my-sm-0 dropdown-toggle");
        }
        else 
        {
        	if(color == "light")
            	navbar.attr("class", "navbar navbar-expand-lg navbar-light rounded custom-navbar");
            else
            	navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            
            navbar.css("background-color","transparent");
            button.attr("class", "btn btn-success my-2 my-sm-0 dropdown-toggle");
        }
    }
    else
    {
        navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
        navbar.css("background-color", user == 2 ? "red" : "rgb(92,184,92)");
        button.attr("class", "btn btn-outline-light my-2 my-sm-0 dropdown-toggle");
    }
} 
</script>
</body>
</html>
