
var editor = null;
var imgpath="../admin/inc";
var bbsurl="";
function initEditor() {
  editor = new WYSIWYD("wysiwyg");
  editor.init();
  return false;
}
WYSIWYD.Config = function () {
	this.baseURL = document.baseURI || document.URL;
	if (this.baseURL && this.baseURL.match(/(.*)\/([^\/]?)/)){
		this.baseURL = RegExp.$1 + "/";
	}
	this.imgURL = imgpath + "/editor/";
	this.toolbar = [
		[ "fontname", "space","fontsize", "space","formatblock", "space"],
		[ "bold", "italic", "underline", "strikethrough", "separator",
		  "subscript", "superscript", "separator",
		  "copy", "cut", "paste","RemoveFormat","separator",
		  "undo", "redo"
		],
		[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator",		  
		  "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator",
		  "createlink", "unlink","separator","br","inserthorizontalrule"
		]
	];
	this.fontname = {
		"":	'',
		"宋体":	'宋体',
		"新宋体":	'新宋体',
		"楷体_GB2312":	'楷体_GB2312',
		"黑体":	'黑体',
		"Arial":	   'arial,helvetica,sans-serif',
		"Courier New":	   'courier new,courier,monospace',
		"Georgia":	   'georgia,times new roman,times,serif',
		"Tahoma":	   'tahoma,arial,helvetica,sans-serif',
		"Times New Roman": 'times new roman,times,serif',
		"Verdana":	   'verdana,arial,helvetica,sans-serif',
		"impact":	   'impact',
		"WingDings":	   'wingdings'
	};
	this.fontsize = {
		"字号":	"",
		"1 (8 pt)":  "1",
		"2 (10 pt)": "2",
		"3 (12 pt)": "3",
		"4 (14 pt)": "4",
		"5 (18 pt)": "5",
		"6 (24 pt)": "6",
		"7 (36 pt)": "7"
	};
	this.formatblock = {
		"段落格式": "",
		"普通": "p",
		"标题一": "h1",
		"标题二": "h2",
		"标题三": "h3",
		"标题四": "h4",
		"标题五": "h5",
		"标题六": "h6",
		"已编排格式": "pre"
	};
	this.btnList = {
		RemoveFormat:[ "删除文字格式", "removeformat.gif", false, function(e) {e.execCommand("RemoveFormat");} ],
		bold: [ "粗体", "bold.gif", false, function(e) {e.execCommand("bold");} ],
		italic: [ "斜体", "italic.gif", false, function(e) {e.execCommand("italic");} ],
		underline: [ "下划线", "underline.gif", false, function(e) {e.execCommand("underline");} ],
		strikethrough: [ "删除线", "strike.gif", false, function(e) {e.execCommand("strikethrough");} ],
		subscript: [ "下标", "sub.gif", false, function(e) {e.execCommand("subscript");} ],
		superscript: [ "上标", "sup.gif", false, function(e) {e.execCommand("superscript");} ],
		justifyleft: [ "左对齐", "justifyleft.gif", false, function(e) {e.execCommand("justifyleft");} ],
		justifycenter: [ "居中", "center.gif", false, function(e) {e.execCommand("justifycenter");} ],
		justifyright: [ "右对齐", "justifyright.gif", false, function(e) {e.execCommand("justifyright");} ],
		justifyfull: [ "左右平等", "justify.gif", false, function(e) {e.execCommand("justifyfull");} ],
		insertorderedlist: [ "有序列表", "list_num.gif", false, function(e) {e.execCommand("insertorderedlist");} ],
		insertunorderedlist: [ "无序列表", "list_bullet.gif", false, function(e) {e.execCommand("insertunorderedlist");} ],
		outdent: [ "取消缩进", "outdent.gif", false, function(e) {e.execCommand("outdent");} ],
		indent: [ "缩进", "indent.gif", false, function(e) {e.execCommand("indent");} ],		
		inserthorizontalrule: [ "插入水平线", "hr.gif", false, function(e) {e.execCommand("inserthorizontalrule");} ],
		createlink: [ "插入url链接", "createlink.gif", false, function(e) {e.execCommand("createlink", true);} ],
		unlink: [ "删除链接", "unlink.gif", false, function(e) {e.execCommand("unlink", true);} ],			
		undo: [ "撤消", "undo.gif", false, function(e) {e.execCommand("undo");} ],
		redo: [ "恢复", "redo.gif", false, function(e) {e.execCommand("redo");} ],
		cut: [ "剪切", "cut.gif", false, function(e) {e.execCommand("cut");} ],
		copy: [ "复制", "copy.gif", false, function(e) {e.execCommand("copy");} ],
		paste: [ "粘贴", "paste.gif", false, function(e) {e.execCommand("paste");} ],			
		br: [ "换行", "br.gif", false, br ],
		sale: [ "", "sale.gif", false, saletable ],
		soft: [ "", "soft.gif", false, softtable ]
	};
	for (var i in this.btnList) {
		var btn = this.btnList[i];
		btn[1] = this.imgURL + btn[1];
	}
};
