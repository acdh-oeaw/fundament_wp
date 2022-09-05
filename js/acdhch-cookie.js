
jQuery(function ($) {
    "use strict";
    /* You can safely use $ in this code block to reference jQuery */
    
    
    var matomoId = $('#matomoID').val();
    //if the user is not defined matomo id, then we will hide the matomo cookie button
    if(matomoId == 0) {
        $(".cookie-accept-btn").hide();
    }
    
    //Toggle expert or basic view on single resource
   function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function removeCookie(cname) {
        document.cookie = cname+'=; Max-Age=-99999999;';  
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    var cookiesAccepted = getCookie("cookiesAccepted");
    var cookiesAcceptedNecessary = getCookie("cookiesAcceptedNecessary");
    
    var _paq = window._paq = window._paq || [];
    if (!cookiesAccepted && !cookiesAcceptedNecessary) {
        $("#cookie-overlay").fadeIn(100);
        _paq.push(['requireConsent']);
    } else if (cookiesAccepted) {
        _paq.push(['trackPageView']);
    }

  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
//Accept cookies
    $(".cookie-accept-btn").on('click', function () {
        removeCookie("cookiesAcceptedNecessary");
        setCookie("cookiesAccepted", true, 180);
        _paq.push(['trackPageView']);
        $("#cookie-overlay").fadeOut(100);
    });

    $(".cookie-accept-necessary-btn").on('click', function () {
        removeCookie("cookiesAccepted");
        setCookie("cookiesAcceptedNecessary", true, 180);
        //Once the function requireConsent is executed then no tracking request will be sent to Matomo and no cookies will be set.
        _paq.push(['requireConsent']);

        $("#cookie-overlay").fadeOut(100);
    });
    
    (function() {
        
        if(matomoId > 0) {
            var u="https://matomo.acdh.oeaw.ac.at/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', matomoId]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        } 
      })();
    /* You can safely use $ in this code block to reference jQuery */
});