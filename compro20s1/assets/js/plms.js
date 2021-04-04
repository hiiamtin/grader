// 8 Sep 2020
function form_submit(obj) {             // obj is button object located inside form
    const form_to_submit = obj.form;
    obj.disabled = true;                // prevent multiple submit
    //console.log(form_to_submit);
    checkSourceCode();
    
    let file_content = get_file_content();
    console.log(`File content ==> ${file_content}`);
    let strip_comment = removeComments(file_content);
    console.log(`Strip comment ==> ${strip_comment}`);
    let header_content = get_header_content(strip_comment);
    console.log(`Header ==> ${header_content}`);


    form_to_submit.submit();
}

function get_file_content() {    
    const input_file = document.querySelector('input[type="file"]');
    var fr1 = new FileReader();
    fr1.onload = function(event) {
        // The file's text will be printed here
        var text = fr1.result;
        // console.log("123456 ==> "+event.target.result);
        // console.log("ttt ==> "+text);
        // var text = removeComments(text);
        // console.log("ttt2 ==> "+text);
        // let count_if = (text.match(/if/g) || []).length;
        // console.log("if="+count_if);
        // let count_for = (text.match(/for/g) || []).length;
        // console.log("for="+count_for);
        // let count_while = (text.match(/while/g) || []).length;
        // console.log("while="+count_while);
        // let count_do = (text.match(/do/g) || []).length;
        // console.log("do="+count_do);
        // let count_switch = (text.match(/switch/g) || []).length;
        // console.log("switch="+count_switch);
        return text;
        };    
}

function get_header_content(strip_comment) {
    header_content = strip_comment;
    return header_content;
}


// 30 Aug 2020
function update_online_student () {
    let URL_ = baseurl+"index.php/plms_json/get_online_student/"+user_id+"/"+user_role;
    //console.log(URL_);
    fetch(URL_)
    .then( (res) => res.json() )
    .then( (data) => {
        //console.log(data);
        let online_students = 0;
        for( row of data) {
            //console.log(row);
            online_students += parseInt(row.num_students);
        }
        //console.log("online students : "+ online_students+" "+ (new Date()));
        document.querySelector("#online_students").innerHTML = `Student  online : ${online_students}`;
    });
   

}
document.addEventListener("DOMContentLoaded", function() {
    //setTimeout(update_online_student,1000);
    //setInterval(update_online_student,60000);
    update_online_student();
    if (user_role == "student") {
        setInterval(update_online_student,300000);
    } else if (user_role == "supervisor") { 
        setInterval(update_online_student,5000);
    } else {
        setInterval(update_online_student,100000);
    }
    
});

function checkSourceCode(){
    var sourceCodeName = document.getElementById("userfile").value;
    if(sourceCodeName==""){
        alert("ไม่มี New Source Code");
        return true;
    }
    var extension = sourceCodeName.split(".");
    var fileName = extension[0].split('\\');
    if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true) {

    } else {
        alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
        return false;
    }
    // if(extension[1]!=document.getElementById("id_extension").value){
    //     alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
    //     return false;
    // }
}

function checkfilename(obj) {
    let filename = obj.value.trim();
    //alert(filename);
    //alert("last char : " + filename.slice(-1));
    if (filename.slice(-1) != "c") {
        console.log(`${filename} ==> Not Accept !!!`);
        alert("อนุญาตให้ส่งไฟล์สกุล .c เท่านั้น");
        obj.value = "";
        return false;
    }
    document.getElementById("exam_submit_bt").disabled = false;
    console.log(`${filename} ==> OK !!!`);

}

function checkfilecontent(obj) {
    checkSourceCode();
}

// 13 Sep 2020
function filecheck(input_file) {    
    //const input_file = document.querySelector('input[type="file"]');
    var fr1 = new FileReader();
    fr1.onload = function(event) {
        // The file's text will be printed here
        var text = fr1.result;
        console.log("123456 ==> "+event.target.result);
        console.log("ttt ==> "+text);
        var text = removeComments(text);
        console.log("ttt2 ==> "+text);
        let count_if = (text.match(/if/g) || []).length;
        console.log("if="+count_if);
        let count_for = (text.match(/for/g) || []).length;
        console.log("for="+count_for);
        let count_while = (text.match(/while/g) || []).length;
        console.log("while="+count_while);
        let count_do = (text.match(/do/g) || []).length;
        console.log("do="+count_do);
        let count_switch = (text.match(/switch/g) || []).length;
        console.log("switch="+count_switch);
        };
    
    // fr1.readAsText(input_file.files[0]);
    // let content1 = fr1.result;
    // console.log("01->"+content1);
    // let content2 = removeComments(content1);
    // console.log("02->"+content2);
    // console.log("03->"+fr1);
    // content1 = fr1.result;
    // console.log("04->"+content1);
    // content2 = removeComments(content1);
    // console.log("05->"+content2);
}

// 13 Sep 2020
function removeComments(str) {
    //console.log("remove");
    //console.log(content);
    //console.log(str);
    str = ('__' + str + '__').split('');
    //console.log("==>"+str);
    // for (var i = 0, l = str.length; i < l; i++) {
    //     console.log(i+"--> "+str[i]+"==>"+str[i].charCodeAt(0));
    // }
    var mode = {
        singleQuote: false,
        doubleQuote: false,
        regex: false,
        blockComment: false,
        lineComment: false,
        condComp: false 
    };
    
    for (var i = 0, l = str.length; i < l; i++) {
    
        if (mode.regex) {
            if (str[i] === '/' && str[i-1] !== `\\`) {
                mode.regex = false;
            }
            continue;
        }
    
        if (mode.singleQuote) {
            if (str[i] === "'" && str[i-1] !== '\\') {
                mode.singleQuote = false;
            }
            continue;
        }
    
        if (mode.doubleQuote) {
            if (str[i] === '"' && str[i-1] !== '\\') {
                mode.doubleQuote = false;
            }
            continue;
        }
    
        if (mode.blockComment) {
            if (str[i] === '*' && str[i+1] === '/') {
                str[i+1] = '';
                mode.blockComment = false;
            }
            str[i] = '';
            continue;
        }
    
        if (mode.lineComment) {
            //if (str[i+1] === 'n' || str[i+1] === 'r') {
            if (str[i+1].charCodeAt(0) == 10) {
                
                mode.lineComment = false;
                str[i] ='';
                i=i+1;
                continue;
            }
            str[i] = '';
            continue;
        }
    
        if (mode.condComp) {
            if (str[i-2] === '@' && str[i-1] === '*' && str[i] === '/') {
                mode.condComp = false;
            }
            continue;
        }
    
        mode.doubleQuote = str[i] === '"';
        mode.singleQuote = str[i] === "'";
    
        if (str[i] === '/') {
    
            if (str[i+1] === '*' && str[i+2] === '@') {
                mode.condComp = true;
                continue;
            }
            if (str[i+1] === '*') {
                str[i] = '';
                mode.blockComment = true;
                continue;
            }
            if (str[i+1] === '/') {
                str[i] = '';
                str[i+1] = '';
                i = i+1;
                mode.lineComment = true;
                continue;
            }
            mode.regex = true;
    
        }
    
    }
    
    return str.join('').slice(2, -2);
    
}