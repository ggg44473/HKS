var sys = {};
var ua = navigator.userAgent.toLowerCase();
var s;
(s = ua.match(/edge\/([\d.]+)/)) ? sys.edge = s[1] :
(s = ua.match(/rv:([\d.]+)\) like gecko/)) ? sys.ie = s[1] :
(s = ua.match(/msie ([\d.]+)/)) ? sys.ie = s[1] :
(s = ua.match(/firefox\/([\d.]+)/)) ? sys.firefox = s[1] :
(s = ua.match(/chrome\/([\d.]+)/)) ? sys.chrome = s[1] :
(s = ua.match(/opera.([\d.]+)/)) ? sys.opera = s[1] :
(s = ua.match(/version\/([\d.]+).*safari/)) ? sys.safari = s[1] : 0;

// if (sys.edge) return { broswer : "Edge", version : sys.edge };
// if (sys.ie) return { broswer : "IE", version : sys.ie };
// if (sys.firefox) return { broswer : "Firefox", version : sys.firefox };
// if (sys.opera) return { broswer : "Opera", version : sys.opera };
// if (sys.safari) return { broswer : "Safari", version : sys.safari };

if (sys.safari){
    $('#started_at').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy / mm / dd',
    });
    $('#finished_at').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy / mm / dd',
    });
}



