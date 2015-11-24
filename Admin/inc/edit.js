
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
		"����":	'����',
		"������":	'������',
		"����_GB2312":	'����_GB2312',
		"����":	'����',
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
		"�ֺ�":	"",
		"1 (8 pt)":  "1",
		"2 (10 pt)": "2",
		"3 (12 pt)": "3",
		"4 (14 pt)": "4",
		"5 (18 pt)": "5",
		"6 (24 pt)": "6",
		"7 (36 pt)": "7"
	};
	this.formatblock = {
		"�����ʽ": "",
		"��ͨ": "p",
		"����һ": "h1",
		"�����": "h2",
		"������": "h3",
		"������": "h4",
		"������": "h5",
		"������": "h6",
		"�ѱ��Ÿ�ʽ": "pre"
	};
	this.btnList = {
		RemoveFormat:[ "ɾ�����ָ�ʽ", "removeformat.gif", false, function(e) {e.execCommand("RemoveFormat");} ],
		bold: [ "����", "bold.gif", false, function(e) {e.execCommand("bold");} ],
		italic: [ "б��", "italic.gif", false, function(e) {e.execCommand("italic");} ],
		underline: [ "�»���", "underline.gif", false, function(e) {e.execCommand("underline");} ],
		strikethrough: [ "ɾ����", "strike.gif", false, function(e) {e.execCommand("strikethrough");} ],
		subscript: [ "�±�", "sub.gif", false, function(e) {e.execCommand("subscript");} ],
		superscript: [ "�ϱ�", "sup.gif", false, function(e) {e.execCommand("superscript");} ],
		justifyleft: [ "�����", "justifyleft.gif", false, function(e) {e.execCommand("justifyleft");} ],
		justifycenter: [ "����", "center.gif", false, function(e) {e.execCommand("justifycenter");} ],
		justifyright: [ "�Ҷ���", "justifyright.gif", false, function(e) {e.execCommand("justifyright");} ],
		justifyfull: [ "����ƽ��", "justify.gif", false, function(e) {e.execCommand("justifyfull");} ],
		insertorderedlist: [ "�����б�", "list_num.gif", false, function(e) {e.execCommand("insertorderedlist");} ],
		insertunorderedlist: [ "�����б�", "list_bullet.gif", false, function(e) {e.execCommand("insertunorderedlist");} ],
		outdent: [ "ȡ������", "outdent.gif", false, function(e) {e.execCommand("outdent");} ],
		indent: [ "����", "indent.gif", false, function(e) {e.execCommand("indent");} ],		
		inserthorizontalrule: [ "����ˮƽ��", "hr.gif", false, function(e) {e.execCommand("inserthorizontalrule");} ],
		createlink: [ "����url����", "createlink.gif", false, function(e) {e.execCommand("createlink", true);} ],
		unlink: [ "ɾ������", "unlink.gif", false, function(e) {e.execCommand("unlink", true);} ],			
		undo: [ "����", "undo.gif", false, function(e) {e.execCommand("undo");} ],
		redo: [ "�ָ�", "redo.gif", false, function(e) {e.execCommand("redo");} ],
		cut: [ "����", "cut.gif", false, function(e) {e.execCommand("cut");} ],
		copy: [ "����", "copy.gif", false, function(e) {e.execCommand("copy");} ],
		paste: [ "ճ��", "paste.gif", false, function(e) {e.execCommand("paste");} ],			
		br: [ "����", "br.gif", false, br ],
		sale: [ "", "sale.gif", false, saletable ],
		soft: [ "", "soft.gif", false, softtable ]
	};
	for (var i in this.btnList) {
		var btn = this.btnList[i];
		btn[1] = this.imgURL + btn[1];
	}
};
