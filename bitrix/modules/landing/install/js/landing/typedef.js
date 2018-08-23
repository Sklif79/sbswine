/**
 * @typedef {object} blockOptions
 * @property {number|string} id
 * @property {boolean} active
 * @property {blockManifest} manifest
 * @property {string} access
 * @property {number} siteId
 * @property {number} lid
 */

/**
 * @typedef {object} blockManifest
 * @property {{name: string}} block
 * @property {string} code
 * @property {string} namespace
 * @property {?object.<string, nodeManifest>} [nodes]
 * @property {?object.<string, cardManifest>} [cards]
 * @property {?object.<string, string>} [groups]
 */

/**
 * @typedef {object} nodeManifest
 * @property {string} code - Code of node
 * @property {string} handler - Name of node constructor
 * @property {string} name - Name of node
 * @property {string} type - Type of node
 * @property {boolean} allowInlineEdit - Allows inline edit
 * @property {boolean} [skipDom]
 * @property {string} [group]
 * @property {imageDimensions} dimensions
 */

/**
 * @typedef {object} imageDimensions
 * @property {number} width
 * @property {number} height
 */

/**
 * @typedef {object} cardManifest
 * @property {string} name - Card name
 */


/**
 * @typedef {object} nodeOptions
 * @property {HTMLElement} node - Node element
 * @property {nodeManifest} manifest - Node manifest
 * @property {string} selector - Node selector
 * @property {boolean} allowInlineEdit - Allows inline edit
 * @property {function} [onChange] - Function that will be called if contents change
 * @property {function} [onDesignShow] - Function that will be called if need open design panel
 * @property {object} [uploadParams]
 */


/**
 * @typedef {object} addBlockResponse
 * @property {int} id
 * @property {string} content
 * @property {string} content_ext
 * @property {array.<string>} js
 * @property {array.<string>} css
 * @property blockManifest
 */