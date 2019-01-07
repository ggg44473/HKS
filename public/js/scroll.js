//一般會在html的body標籤上加上 onload 與 onunload的事件
//例如 onload="moveScol()" onunload="getScrollPosition()"
function getScrollPosition()
{
    var bodyTop = 0;
    if (typeof window.pageYOffset != "undefined")
    {
        bodyTop = window.pageYOffset;
    }
    else if (typeof document.compatMode != "undefined" && document.compatMode != "BackCompat")
    {
        bodyTop = document.documentElement.scrollTop;
    }
    else if (typeof document.body != "undefined")
    {
        bodyTop = document.body.scrollTop;
    }
    document.cookie = bodyTop; //將Y座標位置紀錄在cookie上
}
 
function moveScol()
{
    var scrollo_y = document.cookie.split(";")[0];
    if (scrollo_y != null) {
        window.scrollTo(100, scrollo_y);
    }
}

$('body').on('load', moveScol);
$('body').on('unload', getScrollPosition);

