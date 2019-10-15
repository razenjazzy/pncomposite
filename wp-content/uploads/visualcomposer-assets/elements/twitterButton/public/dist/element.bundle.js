(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./node_modules/raw-loader/index.js!./twitterButton/editor.css":function(e,t){e.exports='[data-vcv-element-disable-interaction="true"] .vce-tweet-button-inner {\n  position: relative;\n}\n\n[data-vcv-element-disable-interaction="true"] .vce-tweet-button-inner::after {\n  content: "";\n  position: absolute;\n  top: 0;\n  right: 0;\n  bottom: 0;\n  left: 0;\n  z-index: 999;\n}\n\n.vce-tweet-button {\n  min-height: 1em;\n}\n'},"./node_modules/raw-loader/index.js!./twitterButton/styles.css":function(e,t){e.exports=".vce-tweet-button {\n  line-height: 1;\n}\n\n.vce-tweet-button-wrapper {\n  display: inline-block;\n}\n\n.vce-tweet-button iframe {\n  display: block;\n  vertical-align: top;\n}\n\n.vce-tweet-button--align-center {\n  text-align: center;\n}\n\n.vce-tweet-button--align-right {\n  text-align: right;\n}\n\n.vce-tweet-button--align-left {\n  text-align: left;\n}\n\n.vce-tweet-button-inner {\n  vertical-align: top;\n  display: inline-block;\n}\n"},"./twitterButton/component.js":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=c(n("./node_modules/babel-runtime/helpers/extends.js")),o=c(n("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),s=c(n("./node_modules/babel-runtime/helpers/classCallCheck.js")),i=c(n("./node_modules/babel-runtime/helpers/createClass.js")),l=c(n("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),r=c(n("./node_modules/babel-runtime/helpers/inherits.js")),u=c(n("./node_modules/react/index.js"));function c(e){return e&&e.__esModule?e:{default:e}}var p=function(e){function t(){return(0,s.default)(this,t),(0,l.default)(this,(t.__proto__||(0,o.default)(t)).apply(this,arguments))}return(0,r.default)(t,e),(0,i.default)(t,[{key:"componentDidMount",value:function(){this.insertTwitterJs(this.props.atts)}},{key:"componentWillReceiveProps",value:function(e){var t=this.props.atts,n=t.shareText,a=t.tweetAccount,o=t.tweetButtonSize,s=t.buttonType,i=t.username,l=t.showUsername,r=t.hashtagTopic,u=t.tweetText,c="customProps:"+this.props.id+"-"+s+"-"+n+"-"+a+"-"+o+"-"+i+"-"+l+"-"+r+"-"+u,p=e.atts;c!=="customProps:"+e.id+"-"+p.buttonType+"-"+p.shareText+"-"+p.tweetAccount+"-"+p.tweetButtonSize+"-"+p.username+"-"+p.showUsername+"-"+p.hashtagTopic+"-"+p.tweetText&&this.insertTwitterJs(e.atts)}},{key:"insertTwitterJs",value:function(e){var t='<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"><\/script>';t=this.createElementTag(e)+t;var n=this.getDomNode().querySelector(".vce-tweet-button-inner");this.updateInlineHtml(n,t)}},{key:"createElementTag",value:function(e){var t=document.createElement("a"),n=e.shareText,a=e.tweetAccount,o=e.tweetButtonSize,s=e.buttonType,i=e.username,l=e.showUsername,r=e.hashtagTopic,u=e.tweetText,c="twitter-"+s+"-button";s&&"share"===s&&n&&t.setAttribute("data-text",n),s&&("mention"===s||"hashtag"===s)&&u&&t.setAttribute("data-text",u),s&&"share"===s&&a&&(a=a.split("@").pop(),t.setAttribute("data-via",a)),o&&"large"===o&&t.setAttribute("data-size",o),i&&(i=(i=(i=i.split("@").pop()).split("https://twitter.com/").pop()).replace(/\s+/g,"")),r&&(r=(r=(r=r.split("https://twitter.com/hashtag/").pop()).replace("?src=hash","")).replace(/\s+/g,"")),s&&"follow"===s&&t.setAttribute("data-show-screen-name",l.toString());var p={share:"https://twitter.com/share",follow:"https://twitter.com/"+i,mention:"https://twitter.com/intent/tweet?screen_name="+i,hashtag:"https://twitter.com/intent/tweet?button_hashtag="+r}[s],d={share:"Tweet",follow:l?"Follow @"+i:"Follow",mention:"Tweet to @"+i,hashtag:r.split("#").pop()}[s];t.setAttribute("href",p),t.setAttribute("data-show-count","false"),t.className=c,t.innerHTML=d;var m=document.createElement("div");return m.appendChild(t),m.innerHTML}},{key:"render",value:function(){var e=this.props,t=e.id,n=e.atts,o=e.editor,s=n.customClass,i=n.alignment,l=n.metaCustomId,r="vce-tweet-button",c={};"string"==typeof s&&s&&(r+=" "+s),i&&(r+=" vce-tweet-button--align-"+i),l&&(c.id=l);var p=this.applyDO("all");return u.default.createElement("div",(0,a.default)({},c,{className:r},o),u.default.createElement("div",(0,a.default)({className:"vce-tweet-button-wrapper vce",id:"el-"+t},p),u.default.createElement("div",{className:"vce-tweet-button-inner"})))}}]),t}(c(n("./node_modules/vc-cake/index.js")).default.getService("api").elementComponent);t.default=p},"./twitterButton/index.js":function(e,t,n){"use strict";var a=s(n("./node_modules/vc-cake/index.js")),o=s(n("./twitterButton/component.js"));function s(e){return e&&e.__esModule?e:{default:e}}(0,a.default.getService("cook").add)(n("./twitterButton/settings.json"),function(e){e.add(o.default)},{css:n("./node_modules/raw-loader/index.js!./twitterButton/styles.css"),editorCss:n("./node_modules/raw-loader/index.js!./twitterButton/editor.css")},"")},"./twitterButton/settings.json":function(e){e.exports={designOptions:{type:"designOptions",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["buttonType","shareText","tweetText","tweetAccount","hashtagTopic","username","showUsername","tweetButtonSize","alignment","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","designOptions"]},relatedTo:{type:"group",access:"protected",value:["General"]},customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},buttonType:{type:"dropdown",access:"public",value:"share",options:{label:"Button type",values:[{label:"Share Button",value:"share"},{label:"Follow Button",value:"follow"},{label:"Mention Button",value:"mention"},{label:"Hashtag Button",value:"hashtag"}]}},shareText:{type:"string",access:"public",value:"",options:{label:"Tweet text",description:"Add custom tweet text or leave empty to use Auto-suggested. Link to the page will be added automatically.",onChange:{rules:{buttonType:{rule:"value",options:{value:"share"}}},actions:[{action:"toggleVisibility"}]}}},tweetText:{type:"string",access:"public",value:"",options:{label:"Tweet text",onChange:{rules:{buttonType:{rule:"valueIn",options:{values:["mention","hashtag"]}}},actions:[{action:"toggleVisibility"}]}}},tweetAccount:{type:"string",access:"public",value:"",options:{label:"Recommend Account (@username)",description:"Adds via @username at the end of the tweet.",onChange:{rules:{buttonType:{rule:"value",options:{value:"share"}}},actions:[{action:"toggleVisibility"}]}}},hashtagTopic:{type:"string",access:"public",value:"#madeinvc",options:{label:"Paste a hashtag URL or #hashtag",onChange:{rules:{buttonType:{rule:"value",options:{value:"hashtag"}}},actions:[{action:"toggleVisibility"}]}}},username:{type:"string",access:"public",value:"wpbakery",options:{label:"Paste a profile URL or @username",onChange:{rules:{buttonType:{rule:"valueIn",options:{values:["follow","mention"]}}},actions:[{action:"toggleVisibility"}]}}},tweetButtonSize:{type:"dropdown",access:"public",value:"normal",options:{label:"Size",values:[{label:"Normal",value:"normal"},{label:"Large",value:"large"}]}},assetsLibrary:{access:"public",type:"string",value:["animate"]},alignment:{type:"buttonGroup",access:"public",value:"left",options:{label:"Alignment",values:[{label:"Left",value:"left",icon:"vcv-ui-icon-attribute-alignment-left"},{label:"Center",value:"center",icon:"vcv-ui-icon-attribute-alignment-center"},{label:"Right",value:"right",icon:"vcv-ui-icon-attribute-alignment-right"}]}},showUsername:{type:"toggle",access:"public",value:!0,options:{label:"Show username",onChange:{rules:{buttonType:{rule:"value",options:{value:"follow"}}},actions:[{action:"toggleVisibility"}]}}},metaDisableInteractionInEditor:{type:"toggle",access:"protected",value:!0},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique Id to element to link directly to it by using #your_id (for element id use lowercase input only)."}},tag:{access:"protected",type:"string",value:"twitterButton"}}}},[["./twitterButton/index.js"]]]);