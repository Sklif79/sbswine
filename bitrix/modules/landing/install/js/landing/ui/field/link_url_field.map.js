{"version":3,"sources":["link_url_field.js"],"names":["BX","namespace","isBoolean","Landing","Utils","prepend","remove","data","attr","addClass","removeClass","proxy","UI","Field","LinkURL","Text","apply","this","arguments","options","disallowType","layout","disableBlocks","disableCustomURL","classList","add","button","Button","BaseButton","text","message","className","onClick","onListShow","bind","onSelectButtonClick","popup","grid","create","props","gridLeft","gridCenter","gridRight","appendChild","input","preparePlaceholder","typeDropdown","Dropdown","items","name","value","onValueChange","onTypeChange","adjustValue","header","editPrevented","getValue","indexOf","prototype","constructor","__proto__","field","placeholder","removeEventListener","onButtonMouseover","onButtonMouseout","addEventListener","sustomTypeSuggestTimeout","setTimeout","Tool","Suggest","getInstance","show","description","pulseTimeout","clearTimeout","hide","landingRegExp","RegExp","blockRegExp","systemRegExp","test","content","landingId","replace","Panel","URLList","getLanding","then","landing","setValue","createPlaceholder","type","id","ID","TITLE","blockId","parseInt","getBlocks","blocks","forEach","block","requestAnimationFrame","systemCode","systemPages","Main","syspages","page","PopupMenu","Date","onclick","events","onPopupClose","destroy","parentNode","popupWindow","popupContainer","rect","pos","style","top","bottom","left","right","view","onListItemClick","isEditPrevented","enableEdit","attrs","data-placeholder","join","children","onPlaceholderRemoveClick","event","target","fireEvent","onInputHandler","innerText","item","onInputClick","contains","includes","disableEdit","innerHTML","outerHTML","dataset","toString","trim"],"mappings":"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","file":""}