{"version":3,"sources":["base_field.js"],"names":["BX","namespace","escapeHtml","Landing","Utils","isString","random","UI","Field","BaseField","data","this","id","selector","content","title","placeholder","className","descriptionText","description","attribute","property","style","layout","createLayout","header","createHeader","innerHTML","appendChild","input","createInput","dataset","onValueChangeHandler","onValueChange","classList","add","createDescription","addEventListener","onPaste","bind","init","create","props","text","html","currentField","prototype","event","preventDefault","clipboardData","getData","document","execCommand","window","getNode","isChanged","trim","getValue","setValue","value","textOnly","toString","enable","disabled","remove","disable","reset"],"mappings":"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","file":""}