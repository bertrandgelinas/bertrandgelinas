function menuWidget(){"use strict";$j(".uwl_menu_widget ul li.has-sub .uwl-sub-icon, .uwl_menu_widget ul li.has-sub a[href*=#]").on("click",function(s){s.preventDefault(),$j(this).closest("li.has-sub").find("> ul.uwl-sub-menu").is(":visible")?($j(this).closest("li.has-sub").find("> ul.uwl-sub-menu").slideUp(200),$j(this).closest("li.has-sub").removeClass("open-sub")):($j(this).closest("li.has-sub").addClass("open-sub"),$j(this).closest("li.has-sub").find("> ul.uwl-sub-menu").slideDown(200))})}var $j=jQuery.noConflict();$j(document).ready(function(){"use strict";menuWidget()});