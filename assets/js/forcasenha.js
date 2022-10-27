function forcasenha(n, m) {
    if (n < 6) {
        percentage = 0;
        $(".progress-bar").css("background", "#dd4b39");
    } else if (n < 8) {
        percentage = 20;
        $(".progress-bar").css("background", "#9c27b0!");
    } else if (n < 10) {
        percentage = 40;
        $(".progress-bar").css("background", "#ff9800");
    } else {
        percentage = 60;
        $(".progress-bar").css("background", "#4caf50");
    }

    // Check for the character-set constraints
    // and update percentage variable as needed.
    
    //Lowercase Words only
    if ((m.match(/[a-z]/) != null)) 
    {
        percentage += 10;
    }
    
    //Uppercase Words only
    if ((m.match(/[A-Z]/) != null)) 
    {
        percentage += 10;
    }
    
    //Digits only
    if ((m.match(/0|1|2|3|4|5|6|7|8|9/) != null)) 
    {
        percentage += 10;
    }
    
    //Special characters
    if ((m.match(/\W/) != null) && (m.match(/\D/) != null))
    {
        percentage += 10;
    }

    // Update the width of the progress bar
    $(".progress-bar").css("width", percentage + "%");
}