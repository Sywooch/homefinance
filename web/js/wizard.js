function createWizard(input) {
  var output = "<div style='padding-right:30px'><table class='wizard'><tbody><tr>";
  var length = input.length;
  var count = 0;
  var post_current = false;
  for (var key in input) {
    var cls = '';
	if (input[count].is_active == true) {
	  cls = "wizard-current";
	  post_current = true;
	} else {
	  if (post_current == true) cls = "wizard-next";
	  else cls = "wizard-prev";
	}
    output += "<td class='" + cls + "' ><div class='wizard-step-wrap' style='z-index:" + (length - count) + "'><div class='wizard-step-text'><table><tbody><tr><td>" + input[count].title + "</td></tr></tbody></table></div><div class='wizard-step-arrow-top' style='z-index:" + (length - count + 2) + "'></div><div class='wizard-step-arrow-bottom' style='z-index:" + (length - count + 1) + "'></div></td>";
    count++;
  }
  output += "</tr></tbody></table></div>";
  document.write(output);
}