(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./node_modules/raw-loader/index.js!./rawJs/editor.css":function(e,t){e.exports="/* ----------------------------------------------\n * Raw JS\n * ---------------------------------------------- */\n.vce-raw-js-container {\n  min-height: 30px;\n}\n"},"./rawJs/component.js":function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=u(s("./node_modules/babel-runtime/helpers/extends.js")),r=u(s("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),o=u(s("./node_modules/babel-runtime/helpers/classCallCheck.js")),n=u(s("./node_modules/babel-runtime/helpers/createClass.js")),i=u(s("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),d=u(s("./node_modules/babel-runtime/helpers/inherits.js")),c=u(s("./node_modules/react/index.js"));function u(e){return e&&e.__esModule?e:{default:e}}var l=function(e){function t(){return(0,o.default)(this,t),(0,i.default)(this,(t.__proto__||(0,r.default)(t)).apply(this,arguments))}return(0,d.default)(t,e),(0,n.default)(t,[{key:"componentDidMount",value:function(){this.props.editor&&this.updateJsScript(this.props.atts.rawJs)}},{key:"componentWillReceiveProps",value:function(e){this.props.editor&&this.updateJsScript(e.atts.rawJs)}},{key:"updateJsScript",value:function(e){var t=this.refs.rawJsWrapper;this.updateInlineScript(t,e)}},{key:"render",value:function(){var e=this.props,t=e.id,s=e.atts,r=e.editor,o=s.customClass,n=s.metaCustomId,i="vce-raw-js-container",d={};"string"==typeof o&&o&&(i=i.concat(" "+o)),n&&(d.id=n);var u=this.applyDO("all");return c.default.createElement("div",(0,a.default)({className:i},r,d),c.default.createElement("div",(0,a.default)({className:"vce-raw-js-wrapper",id:"el-"+t},u,{ref:"rawJsWrapper"})))}}]),t}((0,s("./node_modules/vc-cake/index.js").getService)("api").elementComponent);t.default=l},"./rawJs/index.js":function(e,t,s){"use strict";var a=o(s("./node_modules/vc-cake/index.js")),r=o(s("./rawJs/component.js"));function o(e){return e&&e.__esModule?e:{default:e}}s("./rawJs/migrationWPB.js"),(0,a.default.getService("cook").add)(s("./rawJs/settings.json"),function(e){e.add(r.default)},{css:!1,editorCss:s("./node_modules/raw-loader/index.js!./rawJs/editor.css")},"")},"./rawJs/migrationWPB.js":function(e,t,s){"use strict";var a=function(e){return e&&e.__esModule?e:{default:e}}(s("./node_modules/babel-runtime/core-js/object/assign.js")),r=s("./node_modules/vc-cake/index.js");var o=(0,r.getService)("cook"),n=(0,r.getService)("utils"),i=(0,r.getStorage)("migration");i.on("migrateElement",function(e){if("vc_raw_js"===e.tag){var t=e._generalElementAttributes;t.rawJs=decodeURIComponent(n.base64decode(e._subInnerContent.replace(/^#E-8_/,"").trim())),t.rawJs=t.rawJs.replace(/<\/?script[^>]*>/g,"");var s=(0,a.default)({},t,{tag:"rawJs"}),r=o.get(s);i.trigger("add",r.toJS()),e._migrated=!0}})},"./rawJs/settings.json":function(e){e.exports={rawJs:{type:"rawCode",access:"public",value:"var d=document;d.currentScript&&d.currentScript.parentNode.insertBefore(d.createTextNode('JavaScript is a high-level, dynamic, untyped, and interpreted programming language.'),d.currentScript)",options:{label:"Raw JS",description:"Add your own custom Javascript code to WordPress website to execute it on this particular page.",mode:"javascript"}},customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},designOptions:{type:"designOptions",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["rawJs","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","designOptions"]},relatedTo:{type:"group",access:"protected",value:["General"]},metaBackendLabels:{type:"group",access:"protected",value:[{value:["rawJs"]}]},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique Id to element to link directly to it by using #your_id (for element id use lowercase input only)."}},tag:{access:"protected",type:"string",value:"rawJs"}}}},[["./rawJs/index.js"]]]);