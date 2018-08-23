{"version":3,"sources":["link_panel.js"],"names":["BX","namespace","attr","Landing","Utils","join","random","setTextContent","isPlainObject","UI","Panel","Link","id","data","Content","apply","this","arguments","layout","classList","add","overlay","appendFooterButton","Button","BaseButton","text","message","onClick","save","bind","className","hide","document","body","appendChild","instance","getInstance","title","prototype","constructor","__proto__","show","node","form","innerHTML","Block","Node","Form","BaseForm","manifest","name","field","getField","addField","clear","appendForm","call","EditorPanel","Text","Field","range","getSelection","getRangeAt","textField","BaseField","currentField","isEditable","link","cloneContents","querySelector","href","target","getAttribute","remove","header","content","toString","options","siteId","Main","site_id","landingId","filter","=TYPE","params","type","isChanged","setValue","getValue","value","removeAllRanges","addRange","enableEdit","tmpHref","selection","execCommand","anchorNode","parentElement","attrs"],"mappings":"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","file":""}