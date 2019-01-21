var st_d = new Date(); //获取系统时间  
var y = st_d.getFullYear();
var m = st_d.getMonth();
var d = st_d.getDay();


$("#calendar").fullCalendar({

    header: { // 頂部排版
        left: "prev,next today", // 左邊放置上一頁、下一頁和今天
        center: "title", // 中間放置標題
        right: "month,basicWeek,basicDay" // 右邊放置月、周、天
    },
    editable: true, // 啟動拖曳調整日期

    navLinks: true, // can click day/week names to navigate views
    dayClick: function (date, event, view) {
        console.log('add event');
        console.log(date);
        console.log(event);
        console.log(view);
    },
    eventClick: function (date, event, view) {
        console.log('modify event');
        console.log(date);
        console.log(event);
        console.log(view);
    },
    events: [{
        title: '昨天的活動',
        start: moment().subtract(1, 'days').format('YYYY-MM-DD')
    }, {
        title: '持續一周的活動',
        start: moment().add(7, 'days').format('YYYY-MM-DD'),
        end: moment().add(14, 'days').format('YYYY-MM-DD'),
        color: 'lightBlue'
    }]
});

//動態產生活動釋例
$('#calendar').fullCalendar('renderEvent', {
    title: '明天的活動',
    start: moment().add(1, 'days').format('YYYY-MM-DD')
});

$('#calendar').fullCalendar('renderEvent', {
    id: 'eventGroup1',
    title: '活動1',
    start: moment().add(3, 'days').format('YYYY-MM-DD'),
    textColor: 'black',
    color: 'beige'
});

$('#calendar').fullCalendar('renderEvent', {
    id: 'eventGroup1',
    title: '活動2',
    start: moment().add(5, 'days').format('YYYY-MM-DD'),
    textColor: 'black',
    color: 'beige'
});