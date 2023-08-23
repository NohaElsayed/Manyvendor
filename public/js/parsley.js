(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('jquery')) : typeof define === 'function' && define.amd ? define(['jquery'], factory) : (global = global || self, global.parsley = factory(global.jQuery));
}(this, (function ($) {
    'use strict';

    function _typeof(obj) {
        if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
            _typeof = function (obj) {
                return typeof obj;
            };
        } else {
            _typeof = function (obj) {
                return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
            };
        }
        return _typeof(obj);
    }

    function _extends() {
        _extends = Object.assign || function (target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
            return target;
        };
        return _extends.apply(this, arguments);
    }

    function _slicedToArray(arr, i) {
        return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest();
    }

    function _toConsumableArray(arr) {
        return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
    }

    function _arrayWithoutHoles(arr) {
        if (Array.isArray(arr)) {
            for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) arr2[i] = arr[i];
            return arr2;
        }
    }

    function _arrayWithHoles(arr) {
        if (Array.isArray(arr)) return arr;
    }

    function _iterableToArray(iter) {
        if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
    }

    function _iterableToArrayLimit(arr, i) {
        if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) {
            return;
        }
        var _arr = [];
        var _n = true;
        var _d = false;
        var _e = undefined;
        try {
            for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
                _arr.push(_s.value);
                if (i && _arr.length === i) break;
            }
        } catch (err) {
            _d = true;
            _e = err;
        } finally {
            try {
                if (!_n && _i["return"] != null) _i["return"]();
            } finally {
                if (_d) throw _e;
            }
        }
        return _arr;
    }

    function _nonIterableSpread() {
        throw new TypeError("Invalid attempt to spread non-iterable instance");
    }

    function _nonIterableRest() {
        throw new TypeError("Invalid attempt to destructure non-iterable instance");
    }
    var globalID = 1;
    var pastWarnings = {};
    var Utils = {
        attr: function attr(element, namespace, obj) {
            var i;
            var attribute;
            var attributes;
            var regex = new RegExp('^' + namespace, 'i');
            if ('undefined' === typeof obj) obj = {};
            else {
                for (i in obj) {
                    if (obj.hasOwnProperty(i)) delete obj[i];
                }
            }
            if (!element) return obj;
            attributes = element.attributes;
            for (i = attributes.length; i--;) {
                attribute = attributes[i];
                if (attribute && attribute.specified && regex.test(attribute.name)) {
                    obj[this.camelize(attribute.name.slice(namespace.length))] = this.deserializeValue(attribute.value);
                }
            }
            return obj;
        },
        checkAttr: function checkAttr(element, namespace, _checkAttr) {
            return element.hasAttribute(namespace + _checkAttr);
        },
        setAttr: function setAttr(element, namespace, attr, value) {
            element.setAttribute(this.dasherize(namespace + attr), String(value));
        },
        getType: function getType(element) {
            return element.getAttribute('type') || 'text';
        },
        generateID: function generateID() {
            return '' + globalID++;
        },
        deserializeValue: function deserializeValue(value) {
            var num;
            try {
                return value ? value == "true" || (value == "false" ? false : value == "null" ? null : !isNaN(num = Number(value)) ? num : /^[\[\{]/.test(value) ? JSON.parse(value) : value) : value;
            } catch (e) {
                return value;
            }
        },
        camelize: function camelize(str) {
            return str.replace(/-+(.)?/g, function (match, chr) {
                return chr ? chr.toUpperCase() : '';
            });
        },
        dasherize: function dasherize(str) {
            return str.replace(/::/g, '/').replace(/([A-Z]+)([A-Z][a-z])/g, '$1_$2').replace(/([a-z\d])([A-Z])/g, '$1_$2').replace(/_/g, '-').toLowerCase();
        },
        warn: function warn() {
            var _window$console;
            if (window.console && 'function' === typeof window.console.warn)(_window$console = window.console).warn.apply(_window$console, arguments);
        },
        warnOnce: function warnOnce(msg) {
            if (!pastWarnings[msg]) {
                pastWarnings[msg] = true;
                this.warn.apply(this, arguments);
            }
        },
        _resetWarnings: function _resetWarnings() {
            pastWarnings = {};
        },
        trimString: function trimString(string) {
            return string.replace(/^\s+|\s+$/g, '');
        },
        parse: {
            date: function date(string) {
                var parsed = string.match(/^(\d{4,})-(\d\d)-(\d\d)$/);
                if (!parsed) return null;
                var _parsed$map = parsed.map(function (x) {
                        return parseInt(x, 10);
                    }),
                    _parsed$map2 = _slicedToArray(_parsed$map, 4),
                    _ = _parsed$map2[0],
                    year = _parsed$map2[1],
                    month = _parsed$map2[2],
                    day = _parsed$map2[3];
                var date = new Date(year, month - 1, day);
                if (date.getFullYear() !== year || date.getMonth() + 1 !== month || date.getDate() !== day) return null;
                return date;
            },
            string: function string(_string) {
                return _string;
            },
            integer: function integer(string) {
                if (isNaN(string)) return null;
                return parseInt(string, 10);
            },
            number: function number(string) {
                if (isNaN(string)) throw null;
                return parseFloat(string);
            },
            'boolean': function _boolean(string) {
                return !/^\s*false\s*$/i.test(string);
            },
            object: function object(string) {
                return Utils.deserializeValue(string);
            },
            regexp: function regexp(_regexp) {
                var flags = '';
                if (/^\/.*\/(?:[gimy]*)$/.test(_regexp)) {
                    flags = _regexp.replace(/.*\/([gimy]*)$/, '$1');
                    _regexp = _regexp.replace(new RegExp('^/(.*?)/' + flags + '$'), '$1');
                } else {
                    _regexp = '^' + _regexp + '$';
                }
                return new RegExp(_regexp, flags);
            }
        },
        parseRequirement: function parseRequirement(requirementType, string) {
            var converter = this.parse[requirementType || 'string'];
            if (!converter) throw 'Unknown requirement specification: "' + requirementType + '"';
            var converted = converter(string);
            if (converted === null) throw "Requirement is not a ".concat(requirementType, ": \"").concat(string, "\"");
            return converted;
        },
        namespaceEvents: function namespaceEvents(events, namespace) {
            events = this.trimString(events || '').split(/\s+/);
            if (!events[0]) return '';
            return $.map(events, function (evt) {
                return "".concat(evt, ".").concat(namespace);
            }).join(' ');
        },
        difference: function difference(array, remove) {
            var result = [];
            $.each(array, function (_, elem) {
                if (remove.indexOf(elem) == -1) result.push(elem);
            });
            return result;
        },
        all: function all(promises) {
            return $.when.apply($, _toConsumableArray(promises).concat([42, 42]));
        },
        objectCreate: Object.create || function () {
            var Object = function Object() {};
            return function (prototype) {
                if (arguments.length > 1) {
                    throw Error('Second argument not supported');
                }
                if (_typeof(prototype) != 'object') {
                    throw TypeError('Argument must be an object');
                }
                Object.prototype = prototype;
                var result = new Object();
                Object.prototype = null;
                return result;
            };
        }(),
        _SubmitSelector: 'input[type="submit"], button:submit'
    };
    var Defaults = {
        namespace: 'data-parsley-',
        inputs: 'input, textarea, select',
        excluded: 'input[type=button], input[type=submit], input[type=reset], input[type=hidden]',
        priorityEnabled: true,
        multiple: null,
        group: null,
        uiEnabled: true,
        validationThreshold: 3,
        focus: 'first',
        trigger: false,
        triggerAfterFailure: 'input',
        errorClass: 'parsley-error',
        successClass: 'parsley-success',
        classHandler: function classHandler(Field) {},
        errorsContainer: function errorsContainer(Field) {},
        errorsWrapper: '<ul class="parsley-errors-list"></ul>',
        errorTemplate: '<li></li>'
    };
    var Base = function Base() {
        this.__id__ = Utils.generateID();
    };
    Base.prototype = {
        asyncSupport: true,
        _pipeAccordingToValidationResult: function _pipeAccordingToValidationResult() {
            var _this = this;
            var pipe = function pipe() {
                var r = $.Deferred();
                if (true !== _this.validationResult) r.reject();
                return r.resolve().promise();
            };
            return [pipe, pipe];
        },
        actualizeOptions: function actualizeOptions() {
            Utils.attr(this.element, this.options.namespace, this.domOptions);
            if (this.parent && this.parent.actualizeOptions) this.parent.actualizeOptions();
            return this;
        },
        _resetOptions: function _resetOptions(initOptions) {
            this.domOptions = Utils.objectCreate(this.parent.options);
            this.options = Utils.objectCreate(this.domOptions);
            for (var i in initOptions) {
                if (initOptions.hasOwnProperty(i)) this.options[i] = initOptions[i];
            }
            this.actualizeOptions();
        },
        _listeners: null,
        on: function on(name, fn) {
            this._listeners = this._listeners || {};
            var queue = this._listeners[name] = this._listeners[name] || [];
            queue.push(fn);
            return this;
        },
        subscribe: function subscribe(name, fn) {
            $.listenTo(this, name.toLowerCase(), fn);
        },
        off: function off(name, fn) {
            var queue = this._listeners && this._listeners[name];
            if (queue) {
                if (!fn) {
                    delete this._listeners[name];
                } else {
                    for (var i = queue.length; i--;) {
                        if (queue[i] === fn) queue.splice(i, 1);
                    }
                }
            }
            return this;
        },
        unsubscribe: function unsubscribe(name, fn) {
            $.unsubscribeTo(this, name.toLowerCase());
        },
        trigger: function trigger(name, target, extraArg) {
            target = target || this;
            var queue = this._listeners && this._listeners[name];
            var result;
            if (queue) {
                for (var i = queue.length; i--;) {
                    result = queue[i].call(target, target, extraArg);
                    if (result === false) return result;
                }
            }
            if (this.parent) {
                return this.parent.trigger(name, target, extraArg);
            }
            return true;
        },
        asyncIsValid: function asyncIsValid(group, force) {
            Utils.warnOnce("asyncIsValid is deprecated; please use whenValid instead");
            return this.whenValid({
                group: group,
                force: force
            });
        },
        _findRelated: function _findRelated() {
            return this.options.multiple ? $(this.parent.element.querySelectorAll("[".concat(this.options.namespace, "multiple=\"").concat(this.options.multiple, "\"]"))) : this.$element;
        }
    };
    var convertArrayRequirement = function convertArrayRequirement(string, length) {
        var m = string.match(/^\s*\[(.*)\]\s*$/);
        if (!m) throw 'Requirement is not an array: "' + string + '"';
        var values = m[1].split(',').map(Utils.trimString);
        if (values.length !== length) throw 'Requirement has ' + values.length + ' values when ' + length + ' are needed';
        return values;
    };
    var convertExtraOptionRequirement = function convertExtraOptionRequirement(requirementSpec, string, extraOptionReader) {
        var main = null;
        var extra = {};
        for (var key in requirementSpec) {
            if (key) {
                var value = extraOptionReader(key);
                if ('string' === typeof value) value = Utils.parseRequirement(requirementSpec[key], value);
                extra[key] = value;
            } else {
                main = Utils.parseRequirement(requirementSpec[key], string);
            }
        }
        return [main, extra];
    };
    var Validator = function Validator(spec) {
        $.extend(true, this, spec);
    };
    Validator.prototype = {
        validate: function validate(value, requirementFirstArg) {
            if (this.fn) {
                if (arguments.length > 3)
                    requirementFirstArg = [].slice.call(arguments, 1, -1);
                return this.fn(value, requirementFirstArg);
            }
            if (Array.isArray(value)) {
                if (!this.validateMultiple) throw 'Validator `' + this.name + '` does not handle multiple values';
                return this.validateMultiple.apply(this, arguments);
            } else {
                var instance = arguments[arguments.length - 1];
                if (this.validateDate && instance._isDateInput()) {
                    arguments[0] = Utils.parse.date(arguments[0]);
                    if (arguments[0] === null) return false;
                    return this.validateDate.apply(this, arguments);
                }
                if (this.validateNumber) {
                    if (!value)
                        return true;
                    if (isNaN(value)) return false;
                    arguments[0] = parseFloat(arguments[0]);
                    return this.validateNumber.apply(this, arguments);
                }
                if (this.validateString) {
                    return this.validateString.apply(this, arguments);
                }
                throw 'Validator `' + this.name + '` only handles multiple values';
            }
        },
        parseRequirements: function parseRequirements(requirements, extraOptionReader) {
            if ('string' !== typeof requirements) {
                return Array.isArray(requirements) ? requirements : [requirements];
            }
            var type = this.requirementType;
            if (Array.isArray(type)) {
                var values = convertArrayRequirement(requirements, type.length);
                for (var i = 0; i < values.length; i++) {
                    values[i] = Utils.parseRequirement(type[i], values[i]);
                }
                return values;
            } else if ($.isPlainObject(type)) {
                return convertExtraOptionRequirement(type, requirements, extraOptionReader);
            } else {
                return [Utils.parseRequirement(type, requirements)];
            }
        },
        requirementType: 'string',
        priority: 2
    };
    var ValidatorRegistry = function ValidatorRegistry(validators, catalog) {
        this.__class__ = 'ValidatorRegistry';
        this.locale = 'en';
        this.init(validators || {}, catalog || {});
    };
    var typeTesters = {
        email: /^((([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))$/,
        number: /^-?(\d*\.)?\d+(e[-+]?\d+)?$/i,
        integer: /^-?\d+$/,
        digits: /^\d+$/,
        alphanum: /^\w+$/i,
        date: {
            test: function test(value) {
                return Utils.parse.date(value) !== null;
            }
        },
        url: new RegExp("^" + "(?:(?:https?|ftp)://)?" + "(?:\\S+(?::\\S*)?@)?" + "(?:" + "(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])" + "(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}" + "(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))" + "|" + "(?:(?:[a-zA-Z\\u00a1-\\uffff0-9]-*)*[a-zA-Z\\u00a1-\\uffff0-9]+)" + "(?:\\.(?:[a-zA-Z\\u00a1-\\uffff0-9]-*)*[a-zA-Z\\u00a1-\\uffff0-9]+)*" + "(?:\\.(?:[a-zA-Z\\u00a1-\\uffff]{2,}))" + ")" + "(?::\\d{2,5})?" + "(?:/\\S*)?" + "$")
    };
    typeTesters.range = typeTesters.number;
    var decimalPlaces = function decimalPlaces(num) {
        var match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        if (!match) {
            return 0;
        }
        return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
    };
    var parseArguments = function parseArguments(type, args) {
        return args.map(Utils.parse[type]);
    };
    var operatorToValidator = function operatorToValidator(type, operator) {
        return function (value) {
            for (var _len = arguments.length, requirementsAndInput = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                requirementsAndInput[_key - 1] = arguments[_key];
            }
            requirementsAndInput.pop();
            return operator.apply(void 0, [value].concat(_toConsumableArray(parseArguments(type, requirementsAndInput))));
        };
    };
    var comparisonOperator = function comparisonOperator(operator) {
        return {
            validateDate: operatorToValidator('date', operator),
            validateNumber: operatorToValidator('number', operator),
            requirementType: operator.length <= 2 ? 'string' : ['string', 'string'],
            priority: 30
        };
    };
    ValidatorRegistry.prototype = {
        init: function init(validators, catalog) {
            this.catalog = catalog;
            this.validators = _extends({}, this.validators);
            for (var name in validators) {
                this.addValidator(name, validators[name].fn, validators[name].priority);
            }
            window.Parsley.trigger('parsley:validator:init');
        },
        setLocale: function setLocale(locale) {
            if ('undefined' === typeof this.catalog[locale]) throw new Error(locale + ' is not available in the catalog');
            this.locale = locale;
            return this;
        },
        addCatalog: function addCatalog(locale, messages, set) {
            if ('object' === _typeof(messages)) this.catalog[locale] = messages;
            if (true === set) return this.setLocale(locale);
            return this;
        },
        addMessage: function addMessage(locale, name, message) {
            if ('undefined' === typeof this.catalog[locale]) this.catalog[locale] = {};
            this.catalog[locale][name] = message;
            return this;
        },
        addMessages: function addMessages(locale, nameMessageObject) {
            for (var name in nameMessageObject) {
                this.addMessage(locale, name, nameMessageObject[name]);
            }
            return this;
        },
        addValidator: function addValidator(name, arg1, arg2) {
            if (this.validators[name]) Utils.warn('Validator "' + name + '" is already defined.');
            else if (Defaults.hasOwnProperty(name)) {
                Utils.warn('"' + name + '" is a restricted keyword and is not a valid validator name.');
                return;
            }
            return this._setValidator.apply(this, arguments);
        },
        hasValidator: function hasValidator(name) {
            return !!this.validators[name];
        },
        updateValidator: function updateValidator(name, arg1, arg2) {
            if (!this.validators[name]) {
                Utils.warn('Validator "' + name + '" is not already defined.');
                return this.addValidator.apply(this, arguments);
            }
            return this._setValidator.apply(this, arguments);
        },
        removeValidator: function removeValidator(name) {
            if (!this.validators[name]) Utils.warn('Validator "' + name + '" is not defined.');
            delete this.validators[name];
            return this;
        },
        _setValidator: function _setValidator(name, validator, priority) {
            if ('object' !== _typeof(validator)) {
                validator = {
                    fn: validator,
                    priority: priority
                };
            }
            if (!validator.validate) {
                validator = new Validator(validator);
            }
            this.validators[name] = validator;
            for (var locale in validator.messages || {}) {
                this.addMessage(locale, name, validator.messages[locale]);
            }
            return this;
        },
        getErrorMessage: function getErrorMessage(constraint) {
            var message;
            if ('type' === constraint.name) {
                var typeMessages = this.catalog[this.locale][constraint.name] || {};
                message = typeMessages[constraint.requirements];
            } else message = this.formatMessage(this.catalog[this.locale][constraint.name], constraint.requirements);
            return message || this.catalog[this.locale].defaultMessage || this.catalog.en.defaultMessage;
        },
        formatMessage: function formatMessage(string, parameters) {
            if ('object' === _typeof(parameters)) {
                for (var i in parameters) {
                    string = this.formatMessage(string, parameters[i]);
                }
                return string;
            }
            return 'string' === typeof string ? string.replace(/%s/i, parameters) : '';
        },
        validators: {
            notblank: {
                validateString: function validateString(value) {
                    return /\S/.test(value);
                },
                priority: 2
            },
            required: {
                validateMultiple: function validateMultiple(values) {
                    return values.length > 0;
                },
                validateString: function validateString(value) {
                    return /\S/.test(value);
                },
                priority: 512
            },
            type: {
                validateString: function validateString(value, type) {
                    var _ref = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {},
                        _ref$step = _ref.step,
                        step = _ref$step === void 0 ? 'any' : _ref$step,
                        _ref$base = _ref.base,
                        base = _ref$base === void 0 ? 0 : _ref$base;
                    var tester = typeTesters[type];
                    if (!tester) {
                        throw new Error('validator type `' + type + '` is not supported');
                    }
                    if (!value) return true;
                    if (!tester.test(value)) return false;
                    if ('number' === type) {
                        if (!/^any$/i.test(step || '')) {
                            var nb = Number(value);
                            var decimals = Math.max(decimalPlaces(step), decimalPlaces(base));
                            if (decimalPlaces(nb) > decimals)
                                return false;
                            var toInt = function toInt(f) {
                                return Math.round(f * Math.pow(10, decimals));
                            };
                            if ((toInt(nb) - toInt(base)) % toInt(step) != 0) return false;
                        }
                    }
                    return true;
                },
                requirementType: {
                    '': 'string',
                    step: 'string',
                    base: 'number'
                },
                priority: 256
            },
            pattern: {
                validateString: function validateString(value, regexp) {
                    if (!value) return true;
                    return regexp.test(value);
                },
                requirementType: 'regexp',
                priority: 64
            },
            minlength: {
                validateString: function validateString(value, requirement) {
                    if (!value) return true;
                    return value.length >= requirement;
                },
                requirementType: 'integer',
                priority: 30
            },
            maxlength: {
                validateString: function validateString(value, requirement) {
                    return value.length <= requirement;
                },
                requirementType: 'integer',
                priority: 30
            },
            length: {
                validateString: function validateString(value, min, max) {
                    if (!value) return true;
                    return value.length >= min && value.length <= max;
                },
                requirementType: ['integer', 'integer'],
                priority: 30
            },
            mincheck: {
                validateMultiple: function validateMultiple(values, requirement) {
                    return values.length >= requirement;
                },
                requirementType: 'integer',
                priority: 30
            },
            maxcheck: {
                validateMultiple: function validateMultiple(values, requirement) {
                    return values.length <= requirement;
                },
                requirementType: 'integer',
                priority: 30
            },
            check: {
                validateMultiple: function validateMultiple(values, min, max) {
                    return values.length >= min && values.length <= max;
                },
                requirementType: ['integer', 'integer'],
                priority: 30
            },
            min: comparisonOperator(function (value, requirement) {
                return value >= requirement;
            }),
            max: comparisonOperator(function (value, requirement) {
                return value <= requirement;
            }),
            range: comparisonOperator(function (value, min, max) {
                return value >= min && value <= max;
            }),
            equalto: {
                validateString: function validateString(value, refOrValue) {
                    if (!value) return true;
                    var $reference = $(refOrValue);
                    if ($reference.length) return value === $reference.val();
                    else return value === refOrValue;
                },
                priority: 256
            },
            euvatin: {
                validateString: function validateString(value, refOrValue) {
                    if (!value) {
                        return true;
                    }
                    var re = /^[A-Z][A-Z][A-Za-z0-9 -]{2,}$/;
                    return re.test(value);
                },
                priority: 30
            }
        }
    };
    var UI = {};
    var diffResults = function diffResults(newResult, oldResult, deep) {
        var added = [];
        var kept = [];
        for (var i = 0; i < newResult.length; i++) {
            var found = false;
            for (var j = 0; j < oldResult.length; j++) {
                if (newResult[i].assert.name === oldResult[j].assert.name) {
                    found = true;
                    break;
                }
            }
            if (found) kept.push(newResult[i]);
            else added.push(newResult[i]);
        }
        return {
            kept: kept,
            added: added,
            removed: !deep ? diffResults(oldResult, newResult, true).added : []
        };
    };
    UI.Form = {
        _actualizeTriggers: function _actualizeTriggers() {
            var _this = this;
            this.$element.on('submit.Parsley', function (evt) {
                _this.onSubmitValidate(evt);
            });
            this.$element.on('click.Parsley', Utils._SubmitSelector, function (evt) {
                _this.onSubmitButton(evt);
            });
            if (false === this.options.uiEnabled) return;
            this.element.setAttribute('novalidate', '');
        },
        focus: function focus() {
            this._focusedField = null;
            if (true === this.validationResult || 'none' === this.options.focus) return null;
            for (var i = 0; i < this.fields.length; i++) {
                var field = this.fields[i];
                if (true !== field.validationResult && field.validationResult.length > 0 && 'undefined' === typeof field.options.noFocus) {
                    this._focusedField = field.$element;
                    if ('first' === this.options.focus) break;
                }
            }
            if (null === this._focusedField) return null;
            return this._focusedField.focus();
        },
        _destroyUI: function _destroyUI() {
            this.$element.off('.Parsley');
        }
    };
    UI.Field = {
        _reflowUI: function _reflowUI() {
            this._buildUI();
            if (!this._ui) return;
            var diff = diffResults(this.validationResult, this._ui.lastValidationResult);
            this._ui.lastValidationResult = this.validationResult;
            this._manageStatusClass();
            this._manageErrorsMessages(diff);
            this._actualizeTriggers();
            if ((diff.kept.length || diff.added.length) && !this._failedOnce) {
                this._failedOnce = true;
                this._actualizeTriggers();
            }
        },
        getErrorsMessages: function getErrorsMessages() {
            if (true === this.validationResult) return [];
            var messages = [];
            for (var i = 0; i < this.validationResult.length; i++) {
                messages.push(this.validationResult[i].errorMessage || this._getErrorMessage(this.validationResult[i].assert));
            }
            return messages;
        },
        addError: function addError(name) {
            var _ref = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
                message = _ref.message,
                assert = _ref.assert,
                _ref$updateClass = _ref.updateClass,
                updateClass = _ref$updateClass === void 0 ? true : _ref$updateClass;
            this._buildUI();
            this._addError(name, {
                message: message,
                assert: assert
            });
            if (updateClass) this._errorClass();
        },
        updateError: function updateError(name) {
            var _ref2 = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
                message = _ref2.message,
                assert = _ref2.assert,
                _ref2$updateClass = _ref2.updateClass,
                updateClass = _ref2$updateClass === void 0 ? true : _ref2$updateClass;
            this._buildUI();
            this._updateError(name, {
                message: message,
                assert: assert
            });
            if (updateClass) this._errorClass();
        },
        removeError: function removeError(name) {
            var _ref3 = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
                _ref3$updateClass = _ref3.updateClass,
                updateClass = _ref3$updateClass === void 0 ? true : _ref3$updateClass;
            this._buildUI();
            this._removeError(name);
            if (updateClass) this._manageStatusClass();
        },
        _manageStatusClass: function _manageStatusClass() {
            if (this.hasConstraints() && this.needsValidation() && true === this.validationResult) this._successClass();
            else if (this.validationResult.length > 0) this._errorClass();
            else this._resetClass();
        },
        _manageErrorsMessages: function _manageErrorsMessages(diff) {
            if ('undefined' !== typeof this.options.errorsMessagesDisabled) return;
            if ('undefined' !== typeof this.options.errorMessage) {
                if (diff.added.length || diff.kept.length) {
                    this._insertErrorWrapper();
                    if (0 === this._ui.$errorsWrapper.find('.parsley-custom-error-message').length) this._ui.$errorsWrapper.append($(this.options.errorTemplate).addClass('parsley-custom-error-message'));
                    this._ui.$errorClassHandler.attr('aria-describedby', this._ui.errorsWrapperId);
                    return this._ui.$errorsWrapper.addClass('filled').attr('aria-hidden', 'false').find('.parsley-custom-error-message').html(this.options.errorMessage);
                }
                this._ui.$errorClassHandler.removeAttr('aria-describedby');
                return this._ui.$errorsWrapper.removeClass('filled').attr('aria-hidden', 'true').find('.parsley-custom-error-message').remove();
            }
            for (var i = 0; i < diff.removed.length; i++) {
                this._removeError(diff.removed[i].assert.name);
            }
            for (i = 0; i < diff.added.length; i++) {
                this._addError(diff.added[i].assert.name, {
                    message: diff.added[i].errorMessage,
                    assert: diff.added[i].assert
                });
            }
            for (i = 0; i < diff.kept.length; i++) {
                this._updateError(diff.kept[i].assert.name, {
                    message: diff.kept[i].errorMessage,
                    assert: diff.kept[i].assert
                });
            }
        },
        _addError: function _addError(name, _ref4) {
            var message = _ref4.message,
                assert = _ref4.assert;
            this._insertErrorWrapper();
            this._ui.$errorClassHandler.attr('aria-describedby', this._ui.errorsWrapperId);
            this._ui.$errorsWrapper.addClass('filled').attr('aria-hidden', 'false').append($(this.options.errorTemplate).addClass('parsley-' + name).html(message || this._getErrorMessage(assert)));
        },
        _updateError: function _updateError(name, _ref5) {
            var message = _ref5.message,
                assert = _ref5.assert;
            this._ui.$errorsWrapper.addClass('filled').find('.parsley-' + name).html(message || this._getErrorMessage(assert));
        },
        _removeError: function _removeError(name) {
            this._ui.$errorClassHandler.removeAttr('aria-describedby');
            this._ui.$errorsWrapper.removeClass('filled').attr('aria-hidden', 'true').find('.parsley-' + name).remove();
        },
        _getErrorMessage: function _getErrorMessage(constraint) {
            var customConstraintErrorMessage = constraint.name + 'Message';
            if ('undefined' !== typeof this.options[customConstraintErrorMessage]) return window.Parsley.formatMessage(this.options[customConstraintErrorMessage], constraint.requirements);
            return window.Parsley.getErrorMessage(constraint);
        },
        _buildUI: function _buildUI() {
            if (this._ui || false === this.options.uiEnabled) return;
            var _ui = {};
            this.element.setAttribute(this.options.namespace + 'id', this.__id__);
            _ui.$errorClassHandler = this._manageClassHandler();
            _ui.errorsWrapperId = 'parsley-id-' + (this.options.multiple ? 'multiple-' + this.options.multiple : this.__id__);
            _ui.$errorsWrapper = $(this.options.errorsWrapper).attr('id', _ui.errorsWrapperId);
            _ui.lastValidationResult = [];
            _ui.validationInformationVisible = false;
            this._ui = _ui;
        },
        _manageClassHandler: function _manageClassHandler() {
            if ('string' === typeof this.options.classHandler && $(this.options.classHandler).length) return $(this.options.classHandler);
            var $handlerFunction = this.options.classHandler;
            if ('string' === typeof this.options.classHandler && 'function' === typeof window[this.options.classHandler]) $handlerFunction = window[this.options.classHandler];
            if ('function' === typeof $handlerFunction) {
                var $handler = $handlerFunction.call(this, this);
                if ('undefined' !== typeof $handler && $handler.length) return $handler;
            } else if ('object' === _typeof($handlerFunction) && $handlerFunction instanceof jQuery && $handlerFunction.length) {
                return $handlerFunction;
            } else if ($handlerFunction) {
                Utils.warn('The class handler `' + $handlerFunction + '` does not exist in DOM nor as a global JS function');
            }
            return this._inputHolder();
        },
        _inputHolder: function _inputHolder() {
            if (!this.options.multiple || this.element.nodeName === 'SELECT') return this.$element;
            return this.$element.parent();
        },
        _insertErrorWrapper: function _insertErrorWrapper() {
            var $errorsContainer = this.options.errorsContainer;
            if (0 !== this._ui.$errorsWrapper.parent().length) return this._ui.$errorsWrapper.parent();
            if ('string' === typeof $errorsContainer) {
                if ($($errorsContainer).length) return $($errorsContainer).append(this._ui.$errorsWrapper);
                else if ('function' === typeof window[$errorsContainer]) $errorsContainer = window[$errorsContainer];
                else Utils.warn('The errors container `' + $errorsContainer + '` does not exist in DOM nor as a global JS function');
            }
            if ('function' === typeof $errorsContainer) $errorsContainer = $errorsContainer.call(this, this);
            if ('object' === _typeof($errorsContainer) && $errorsContainer.length) return $errorsContainer.append(this._ui.$errorsWrapper);
            return this._inputHolder().after(this._ui.$errorsWrapper);
        },
        _actualizeTriggers: function _actualizeTriggers() {
            var _this2 = this;
            var $toBind = this._findRelated();
            var trigger;
            $toBind.off('.Parsley');
            if (this._failedOnce) $toBind.on(Utils.namespaceEvents(this.options.triggerAfterFailure, 'Parsley'), function () {
                _this2._validateIfNeeded();
            });
            else if (trigger = Utils.namespaceEvents(this.options.trigger, 'Parsley')) {
                $toBind.on(trigger, function (event) {
                    _this2._validateIfNeeded(event);
                });
            }
        },
        _validateIfNeeded: function _validateIfNeeded(event) {
            var _this3 = this;
            if (event && /key|input/.test(event.type))
                if (!(this._ui && this._ui.validationInformationVisible) && this.getValue().length <= this.options.validationThreshold) return;
            if (this.options.debounce) {
                window.clearTimeout(this._debounced);
                this._debounced = window.setTimeout(function () {
                    return _this3.validate();
                }, this.options.debounce);
            } else this.validate();
        },
        _resetUI: function _resetUI() {
            this._failedOnce = false;
            this._actualizeTriggers();
            if ('undefined' === typeof this._ui) return;
            this._ui.$errorsWrapper.removeClass('filled').children().remove();
            this._resetClass();
            this._ui.lastValidationResult = [];
            this._ui.validationInformationVisible = false;
        },
        _destroyUI: function _destroyUI() {
            this._resetUI();
            if ('undefined' !== typeof this._ui) this._ui.$errorsWrapper.remove();
            delete this._ui;
        },
        _successClass: function _successClass() {
            this._ui.validationInformationVisible = true;
            this._ui.$errorClassHandler.removeClass(this.options.errorClass).addClass(this.options.successClass);
        },
        _errorClass: function _errorClass() {
            this._ui.validationInformationVisible = true;
            this._ui.$errorClassHandler.removeClass(this.options.successClass).addClass(this.options.errorClass);
        },
        _resetClass: function _resetClass() {
            this._ui.$errorClassHandler.removeClass(this.options.successClass).removeClass(this.options.errorClass);
        }
    };
    var Form = function Form(element, domOptions, options) {
        this.__class__ = 'Form';
        this.element = element;
        this.$element = $(element);
        this.domOptions = domOptions;
        this.options = options;
        this.parent = window.Parsley;
        this.fields = [];
        this.validationResult = null;
    };
    var statusMapping = {
        pending: null,
        resolved: true,
        rejected: false
    };
    Form.prototype = {
        onSubmitValidate: function onSubmitValidate(event) {
            var _this = this;
            if (true === event.parsley) return;
            var submitSource = this._submitSource || this.$element.find(Utils._SubmitSelector)[0];
            this._submitSource = null;
            this.$element.find('.parsley-synthetic-submit-button').prop('disabled', true);
            if (submitSource && null !== submitSource.getAttribute('formnovalidate')) return;
            window.Parsley._remoteCache = {};
            var promise = this.whenValidate({
                event: event
            });
            if ('resolved' === promise.state() && false !== this._trigger('submit'));
            else {
                event.stopImmediatePropagation();
                event.preventDefault();
                if ('pending' === promise.state()) promise.done(function () {
                    _this._submit(submitSource);
                });
            }
        },
        onSubmitButton: function onSubmitButton(event) {
            this._submitSource = event.currentTarget;
        },
        _submit: function _submit(submitSource) {
            if (false === this._trigger('submit')) return;
            if (submitSource) {
                var $synthetic = this.$element.find('.parsley-synthetic-submit-button').prop('disabled', false);
                if (0 === $synthetic.length) $synthetic = $('<input class="parsley-synthetic-submit-button" type="hidden">').appendTo(this.$element);
                $synthetic.attr({
                    name: submitSource.getAttribute('name'),
                    value: submitSource.getAttribute('value')
                });
            }
            this.$element.trigger(_extends($.Event('submit'), {
                parsley: true
            }));
        },
        validate: function validate(options) {
            if (arguments.length >= 1 && !$.isPlainObject(options)) {
                Utils.warnOnce('Calling validate on a parsley form without passing arguments as an object is deprecated.');
                var _arguments = Array.prototype.slice.call(arguments),
                    group = _arguments[0],
                    force = _arguments[1],
                    event = _arguments[2];
                options = {
                    group: group,
                    force: force,
                    event: event
                };
            }
            return statusMapping[this.whenValidate(options).state()];
        },
        whenValidate: function whenValidate() {
            var _this2 = this,
                _Utils$all$done$fail$;
            var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
                group = _ref.group,
                force = _ref.force,
                event = _ref.event;
            this.submitEvent = event;
            if (event) {
                this.submitEvent = _extends({}, event, {
                    preventDefault: function preventDefault() {
                        Utils.warnOnce("Using `this.submitEvent.preventDefault()` is deprecated; instead, call `this.validationResult = false`");
                        _this2.validationResult = false;
                    }
                });
            }
            this.validationResult = true;
            this._trigger('validate');
            this._refreshFields();
            var promises = this._withoutReactualizingFormOptions(function () {
                return $.map(_this2.fields, function (field) {
                    return field.whenValidate({
                        force: force,
                        group: group
                    });
                });
            });
            return (_Utils$all$done$fail$ = Utils.all(promises).done(function () {
                _this2._trigger('success');
            }).fail(function () {
                _this2.validationResult = false;
                _this2.focus();
                _this2._trigger('error');
            }).always(function () {
                _this2._trigger('validated');
            })).pipe.apply(_Utils$all$done$fail$, _toConsumableArray(this._pipeAccordingToValidationResult()));
        },
        isValid: function isValid(options) {
            if (arguments.length >= 1 && !$.isPlainObject(options)) {
                Utils.warnOnce('Calling isValid on a parsley form without passing arguments as an object is deprecated.');
                var _arguments2 = Array.prototype.slice.call(arguments),
                    group = _arguments2[0],
                    force = _arguments2[1];
                options = {
                    group: group,
                    force: force
                };
            }
            return statusMapping[this.whenValid(options).state()];
        },
        whenValid: function whenValid() {
            var _this3 = this;
            var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
                group = _ref2.group,
                force = _ref2.force;
            this._refreshFields();
            var promises = this._withoutReactualizingFormOptions(function () {
                return $.map(_this3.fields, function (field) {
                    return field.whenValid({
                        group: group,
                        force: force
                    });
                });
            });
            return Utils.all(promises);
        },
        refresh: function refresh() {
            this._refreshFields();
            return this;
        },
        reset: function reset() {
            for (var i = 0; i < this.fields.length; i++) {
                this.fields[i].reset();
            }
            this._trigger('reset');
        },
        destroy: function destroy() {
            this._destroyUI();
            for (var i = 0; i < this.fields.length; i++) {
                this.fields[i].destroy();
            }
            this.$element.removeData('Parsley');
            this._trigger('destroy');
        },
        _refreshFields: function _refreshFields() {
            return this.actualizeOptions()._bindFields();
        },
        _bindFields: function _bindFields() {
            var _this4 = this;
            var oldFields = this.fields;
            this.fields = [];
            this.fieldsMappedById = {};
            this._withoutReactualizingFormOptions(function () {
                _this4.$element.find(_this4.options.inputs).not(_this4.options.excluded).not("[".concat(_this4.options.namespace, "excluded=true]")).each(function (_, element) {
                    var fieldInstance = new window.Parsley.Factory(element, {}, _this4);
                    if ('Field' === fieldInstance.__class__ || 'FieldMultiple' === fieldInstance.__class__) {
                        var uniqueId = fieldInstance.__class__ + '-' + fieldInstance.__id__;
                        if ('undefined' === typeof _this4.fieldsMappedById[uniqueId]) {
                            _this4.fieldsMappedById[uniqueId] = fieldInstance;
                            _this4.fields.push(fieldInstance);
                        }
                    }
                });
                $.each(Utils.difference(oldFields, _this4.fields), function (_, field) {
                    field.reset();
                });
            });
            return this;
        },
        _withoutReactualizingFormOptions: function _withoutReactualizingFormOptions(fn) {
            var oldActualizeOptions = this.actualizeOptions;
            this.actualizeOptions = function () {
                return this;
            };
            var result = fn();
            this.actualizeOptions = oldActualizeOptions;
            return result;
        },
        _trigger: function _trigger(eventName) {
            return this.trigger('form:' + eventName);
        }
    };
    var Constraint = function Constraint(parsleyField, name, requirements, priority, isDomConstraint) {
        var validatorSpec = window.Parsley._validatorRegistry.validators[name];
        var validator = new Validator(validatorSpec);
        priority = priority || parsleyField.options[name + 'Priority'] || validator.priority;
        isDomConstraint = true === isDomConstraint;
        _extends(this, {
            validator: validator,
            name: name,
            requirements: requirements,
            priority: priority,
            isDomConstraint: isDomConstraint
        });
        this._parseRequirements(parsleyField.options);
    };
    var capitalize = function capitalize(str) {
        var cap = str[0].toUpperCase();
        return cap + str.slice(1);
    };
    Constraint.prototype = {
        validate: function validate(value, instance) {
            var _this$validator;
            return (_this$validator = this.validator).validate.apply(_this$validator, [value].concat(_toConsumableArray(this.requirementList), [instance]));
        },
        _parseRequirements: function _parseRequirements(options) {
            var _this = this;
            this.requirementList = this.validator.parseRequirements(this.requirements, function (key) {
                return options[_this.name + capitalize(key)];
            });
        }
    };
    var Field = function Field(field, domOptions, options, parsleyFormInstance) {
        this.__class__ = 'Field';
        this.element = field;
        this.$element = $(field);
        if ('undefined' !== typeof parsleyFormInstance) {
            this.parent = parsleyFormInstance;
        }
        this.options = options;
        this.domOptions = domOptions;
        this.constraints = [];
        this.constraintsByName = {};
        this.validationResult = true;
        this._bindConstraints();
    };
    var statusMapping$1 = {
        pending: null,
        resolved: true,
        rejected: false
    };
    Field.prototype = {
        validate: function validate(options) {
            if (arguments.length >= 1 && !$.isPlainObject(options)) {
                Utils.warnOnce('Calling validate on a parsley field without passing arguments as an object is deprecated.');
                options = {
                    options: options
                };
            }
            var promise = this.whenValidate(options);
            if (!promise)
                return true;
            switch (promise.state()) {
                case 'pending':
                    return null;
                case 'resolved':
                    return true;
                case 'rejected':
                    return this.validationResult;
            }
        },
        whenValidate: function whenValidate() {
            var _this$whenValid$alway, _this = this;
            var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
                force = _ref.force,
                group = _ref.group;
            this.refresh();
            if (group && !this._isInGroup(group)) return;
            this.value = this.getValue();
            this._trigger('validate');
            return (_this$whenValid$alway = this.whenValid({
                force: force,
                value: this.value,
                _refreshed: true
            }).always(function () {
                _this._reflowUI();
            }).done(function () {
                _this._trigger('success');
            }).fail(function () {
                _this._trigger('error');
            }).always(function () {
                _this._trigger('validated');
            })).pipe.apply(_this$whenValid$alway, _toConsumableArray(this._pipeAccordingToValidationResult()));
        },
        hasConstraints: function hasConstraints() {
            return 0 !== this.constraints.length;
        },
        needsValidation: function needsValidation(value) {
            if ('undefined' === typeof value) value = this.getValue();
            if (!value.length && !this._isRequired() && 'undefined' === typeof this.options.validateIfEmpty) return false;
            return true;
        },
        _isInGroup: function _isInGroup(group) {
            if (Array.isArray(this.options.group)) return -1 !== $.inArray(group, this.options.group);
            return this.options.group === group;
        },
        isValid: function isValid(options) {
            if (arguments.length >= 1 && !$.isPlainObject(options)) {
                Utils.warnOnce('Calling isValid on a parsley field without passing arguments as an object is deprecated.');
                var _arguments = Array.prototype.slice.call(arguments),
                    force = _arguments[0],
                    value = _arguments[1];
                options = {
                    force: force,
                    value: value
                };
            }
            var promise = this.whenValid(options);
            if (!promise)
                return true;
            return statusMapping$1[promise.state()];
        },
        whenValid: function whenValid() {
            var _this2 = this;
            var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
                _ref2$force = _ref2.force,
                force = _ref2$force === void 0 ? false : _ref2$force,
                value = _ref2.value,
                group = _ref2.group,
                _refreshed = _ref2._refreshed;
            if (!_refreshed) this.refresh();
            if (group && !this._isInGroup(group)) return;
            this.validationResult = true;
            if (!this.hasConstraints()) return $.when();
            if ('undefined' === typeof value || null === value) value = this.getValue();
            if (!this.needsValidation(value) && true !== force) return $.when();
            var groupedConstraints = this._getGroupedConstraints();
            var promises = [];
            $.each(groupedConstraints, function (_, constraints) {
                var promise = Utils.all($.map(constraints, function (constraint) {
                    return _this2._validateConstraint(value, constraint);
                }));
                promises.push(promise);
                if (promise.state() === 'rejected') return false;
            });
            return Utils.all(promises);
        },
        _validateConstraint: function _validateConstraint(value, constraint) {
            var _this3 = this;
            var result = constraint.validate(value, this);
            if (false === result) result = $.Deferred().reject();
            return Utils.all([result]).fail(function (errorMessage) {
                if (!(_this3.validationResult instanceof Array)) _this3.validationResult = [];
                _this3.validationResult.push({
                    assert: constraint,
                    errorMessage: 'string' === typeof errorMessage && errorMessage
                });
            });
        },
        getValue: function getValue() {
            var value;
            if ('function' === typeof this.options.value) value = this.options.value(this);
            else if ('undefined' !== typeof this.options.value) value = this.options.value;
            else value = this.$element.val();
            if ('undefined' === typeof value || null === value) return '';
            return this._handleWhitespace(value);
        },
        reset: function reset() {
            this._resetUI();
            return this._trigger('reset');
        },
        destroy: function destroy() {
            this._destroyUI();
            this.$element.removeData('Parsley');
            this.$element.removeData('FieldMultiple');
            this._trigger('destroy');
        },
        refresh: function refresh() {
            this._refreshConstraints();
            return this;
        },
        _refreshConstraints: function _refreshConstraints() {
            return this.actualizeOptions()._bindConstraints();
        },
        refreshConstraints: function refreshConstraints() {
            Utils.warnOnce("Parsley's refreshConstraints is deprecated. Please use refresh");
            return this.refresh();
        },
        addConstraint: function addConstraint(name, requirements, priority, isDomConstraint) {
            if (window.Parsley._validatorRegistry.validators[name]) {
                var constraint = new Constraint(this, name, requirements, priority, isDomConstraint);
                if ('undefined' !== this.constraintsByName[constraint.name]) this.removeConstraint(constraint.name);
                this.constraints.push(constraint);
                this.constraintsByName[constraint.name] = constraint;
            }
            return this;
        },
        removeConstraint: function removeConstraint(name) {
            for (var i = 0; i < this.constraints.length; i++) {
                if (name === this.constraints[i].name) {
                    this.constraints.splice(i, 1);
                    break;
                }
            }
            delete this.constraintsByName[name];
            return this;
        },
        updateConstraint: function updateConstraint(name, parameters, priority) {
            return this.removeConstraint(name).addConstraint(name, parameters, priority);
        },
        _bindConstraints: function _bindConstraints() {
            var constraints = [];
            var constraintsByName = {};
            for (var i = 0; i < this.constraints.length; i++) {
                if (false === this.constraints[i].isDomConstraint) {
                    constraints.push(this.constraints[i]);
                    constraintsByName[this.constraints[i].name] = this.constraints[i];
                }
            }
            this.constraints = constraints;
            this.constraintsByName = constraintsByName;
            for (var name in this.options) {
                this.addConstraint(name, this.options[name], undefined, true);
            }
            return this._bindHtml5Constraints();
        },
        _bindHtml5Constraints: function _bindHtml5Constraints() {
            if (null !== this.element.getAttribute('required')) this.addConstraint('required', true, undefined, true);
            if (null !== this.element.getAttribute('pattern')) this.addConstraint('pattern', this.element.getAttribute('pattern'), undefined, true);
            var min = this.element.getAttribute('min');
            var max = this.element.getAttribute('max');
            if (null !== min && null !== max) this.addConstraint('range', [min, max], undefined, true);
            else if (null !== min) this.addConstraint('min', min, undefined, true);
            else if (null !== max) this.addConstraint('max', max, undefined, true);
            if (null !== this.element.getAttribute('minlength') && null !== this.element.getAttribute('maxlength')) this.addConstraint('length', [this.element.getAttribute('minlength'), this.element.getAttribute('maxlength')], undefined, true);
            else if (null !== this.element.getAttribute('minlength')) this.addConstraint('minlength', this.element.getAttribute('minlength'), undefined, true);
            else if (null !== this.element.getAttribute('maxlength')) this.addConstraint('maxlength', this.element.getAttribute('maxlength'), undefined, true);
            var type = Utils.getType(this.element);
            if ('number' === type) {
                return this.addConstraint('type', ['number', {
                    step: this.element.getAttribute('step') || '1',
                    base: min || this.element.getAttribute('value')
                }], undefined, true);
            } else if (/^(email|url|range|date)$/i.test(type)) {
                return this.addConstraint('type', type, undefined, true);
            }
            return this;
        },
        _isRequired: function _isRequired() {
            if ('undefined' === typeof this.constraintsByName.required) return false;
            return false !== this.constraintsByName.required.requirements;
        },
        _trigger: function _trigger(eventName) {
            return this.trigger('field:' + eventName);
        },
        _handleWhitespace: function _handleWhitespace(value) {
            if (true === this.options.trimValue) Utils.warnOnce('data-parsley-trim-value="true" is deprecated, please use data-parsley-whitespace="trim"');
            if ('squish' === this.options.whitespace) value = value.replace(/\s{2,}/g, ' ');
            if ('trim' === this.options.whitespace || 'squish' === this.options.whitespace || true === this.options.trimValue) value = Utils.trimString(value);
            return value;
        },
        _isDateInput: function _isDateInput() {
            var c = this.constraintsByName.type;
            return c && c.requirements === 'date';
        },
        _getGroupedConstraints: function _getGroupedConstraints() {
            if (false === this.options.priorityEnabled) return [this.constraints];
            var groupedConstraints = [];
            var index = {};
            for (var i = 0; i < this.constraints.length; i++) {
                var p = this.constraints[i].priority;
                if (!index[p]) groupedConstraints.push(index[p] = []);
                index[p].push(this.constraints[i]);
            }
            groupedConstraints.sort(function (a, b) {
                return b[0].priority - a[0].priority;
            });
            return groupedConstraints;
        }
    };
    var Multiple = function Multiple() {
        this.__class__ = 'FieldMultiple';
    };
    Multiple.prototype = {
        addElement: function addElement($element) {
            this.$elements.push($element);
            return this;
        },
        _refreshConstraints: function _refreshConstraints() {
            var fieldConstraints;
            this.constraints = [];
            if (this.element.nodeName === 'SELECT') {
                this.actualizeOptions()._bindConstraints();
                return this;
            }
            for (var i = 0; i < this.$elements.length; i++) {
                if (!$('html').has(this.$elements[i]).length) {
                    this.$elements.splice(i, 1);
                    continue;
                }
                fieldConstraints = this.$elements[i].data('FieldMultiple')._refreshConstraints().constraints;
                for (var j = 0; j < fieldConstraints.length; j++) {
                    this.addConstraint(fieldConstraints[j].name, fieldConstraints[j].requirements, fieldConstraints[j].priority, fieldConstraints[j].isDomConstraint);
                }
            }
            return this;
        },
        getValue: function getValue() {
            if ('function' === typeof this.options.value) return this.options.value(this);
            else if ('undefined' !== typeof this.options.value) return this.options.value;
            if (this.element.nodeName === 'INPUT') {
                var type = Utils.getType(this.element);
                if (type === 'radio') return this._findRelated().filter(':checked').val() || '';
                if (type === 'checkbox') {
                    var values = [];
                    this._findRelated().filter(':checked').each(function () {
                        values.push($(this).val());
                    });
                    return values;
                }
            }
            if (this.element.nodeName === 'SELECT' && null === this.$element.val()) return [];
            return this.$element.val();
        },
        _init: function _init() {
            this.$elements = [this.$element];
            return this;
        }
    };
    var Factory = function Factory(element, options, parsleyFormInstance) {
        this.element = element;
        this.$element = $(element);
        var savedparsleyFormInstance = this.$element.data('Parsley');
        if (savedparsleyFormInstance) {
            if ('undefined' !== typeof parsleyFormInstance && savedparsleyFormInstance.parent === window.Parsley) {
                savedparsleyFormInstance.parent = parsleyFormInstance;
                savedparsleyFormInstance._resetOptions(savedparsleyFormInstance.options);
            }
            if ('object' === _typeof(options)) {
                _extends(savedparsleyFormInstance.options, options);
            }
            return savedparsleyFormInstance;
        }
        if (!this.$element.length) throw new Error('You must bind Parsley on an existing element.');
        if ('undefined' !== typeof parsleyFormInstance && 'Form' !== parsleyFormInstance.__class__) throw new Error('Parent instance must be a Form instance');
        this.parent = parsleyFormInstance || window.Parsley;
        return this.init(options);
    };
    Factory.prototype = {
        init: function init(options) {
            this.__class__ = 'Parsley';
            this.__version__ = '2.9.2';
            this.__id__ = Utils.generateID();
            this._resetOptions(options);
            if (this.element.nodeName === 'FORM' || Utils.checkAttr(this.element, this.options.namespace, 'validate') && !this.$element.is(this.options.inputs)) return this.bind('parsleyForm');
            return this.isMultiple() ? this.handleMultiple() : this.bind('parsleyField');
        },
        isMultiple: function isMultiple() {
            var type = Utils.getType(this.element);
            return type === 'radio' || type === 'checkbox' || this.element.nodeName === 'SELECT' && null !== this.element.getAttribute('multiple');
        },
        handleMultiple: function handleMultiple() {
            var _this = this;
            var name;
            var parsleyMultipleInstance;
            this.options.multiple = this.options.multiple || (name = this.element.getAttribute('name')) || this.element.getAttribute('id');
            if (this.element.nodeName === 'SELECT' && null !== this.element.getAttribute('multiple')) {
                this.options.multiple = this.options.multiple || this.__id__;
                return this.bind('parsleyFieldMultiple');
            } else if (!this.options.multiple) {
                Utils.warn('To be bound by Parsley, a radio, a checkbox and a multiple select input must have either a name or a multiple option.', this.$element);
                return this;
            }
            this.options.multiple = this.options.multiple.replace(/(:|\.|\[|\]|\{|\}|\$)/g, '');
            if (name) {
                $('input[name="' + name + '"]').each(function (i, input) {
                    var type = Utils.getType(input);
                    if (type === 'radio' || type === 'checkbox') input.setAttribute(_this.options.namespace + 'multiple', _this.options.multiple);
                });
            }
            var $previouslyRelated = this._findRelated();
            for (var i = 0; i < $previouslyRelated.length; i++) {
                parsleyMultipleInstance = $($previouslyRelated.get(i)).data('Parsley');
                if ('undefined' !== typeof parsleyMultipleInstance) {
                    if (!this.$element.data('FieldMultiple')) {
                        parsleyMultipleInstance.addElement(this.$element);
                    }
                    break;
                }
            }
            this.bind('parsleyField', true);
            return parsleyMultipleInstance || this.bind('parsleyFieldMultiple');
        },
        bind: function bind(type, doNotStore) {
            var parsleyInstance;
            switch (type) {
                case 'parsleyForm':
                    parsleyInstance = $.extend(new Form(this.element, this.domOptions, this.options), new Base(), window.ParsleyExtend)._bindFields();
                    break;
                case 'parsleyField':
                    parsleyInstance = $.extend(new Field(this.element, this.domOptions, this.options, this.parent), new Base(), window.ParsleyExtend);
                    break;
                case 'parsleyFieldMultiple':
                    parsleyInstance = $.extend(new Field(this.element, this.domOptions, this.options, this.parent), new Multiple(), new Base(), window.ParsleyExtend)._init();
                    break;
                default:
                    throw new Error(type + 'is not a supported Parsley type');
            }
            if (this.options.multiple) Utils.setAttr(this.element, this.options.namespace, 'multiple', this.options.multiple);
            if ('undefined' !== typeof doNotStore) {
                this.$element.data('FieldMultiple', parsleyInstance);
                return parsleyInstance;
            }
            this.$element.data('Parsley', parsleyInstance);
            parsleyInstance._actualizeTriggers();
            parsleyInstance._trigger('init');
            return parsleyInstance;
        }
    };
    var vernums = $.fn.jquery.split('.');
    if (parseInt(vernums[0]) <= 1 && parseInt(vernums[1]) < 8) {
        throw "The loaded version of jQuery is too old. Please upgrade to 1.8.x or better.";
    }
    if (!vernums.forEach) {
        Utils.warn('Parsley requires ES5 to run properly. Please include https://github.com/es-shims/es5-shim');
    }
    var Parsley = _extends(new Base(), {
        element: document,
        $element: $(document),
        actualizeOptions: null,
        _resetOptions: null,
        Factory: Factory,
        version: '2.9.2'
    });
    _extends(Field.prototype, UI.Field, Base.prototype);
    _extends(Form.prototype, UI.Form, Base.prototype);
    _extends(Factory.prototype, Base.prototype);
    $.fn.parsley = $.fn.psly = function (options) {
        if (this.length > 1) {
            var instances = [];
            this.each(function () {
                instances.push($(this).parsley(options));
            });
            return instances;
        }
        if (this.length == 0) {
            return;
        }
        return new Factory(this[0], options);
    };
    if ('undefined' === typeof window.ParsleyExtend) window.ParsleyExtend = {};
    Parsley.options = _extends(Utils.objectCreate(Defaults), window.ParsleyConfig);
    window.ParsleyConfig = Parsley.options;
    window.Parsley = window.psly = Parsley;
    Parsley.Utils = Utils;
    window.ParsleyUtils = {};
    $.each(Utils, function (key, value) {
        if ('function' === typeof value) {
            window.ParsleyUtils[key] = function () {
                Utils.warnOnce('Accessing `window.ParsleyUtils` is deprecated. Use `window.Parsley.Utils` instead.');
                return Utils[key].apply(Utils, arguments);
            };
        }
    });
    var registry = window.Parsley._validatorRegistry = new ValidatorRegistry(window.ParsleyConfig.validators, window.ParsleyConfig.i18n);
    window.ParsleyValidator = {};
    $.each('setLocale addCatalog addMessage addMessages getErrorMessage formatMessage addValidator updateValidator removeValidator hasValidator'.split(' '), function (i, method) {
        window.Parsley[method] = function () {
            return registry[method].apply(registry, arguments);
        };
        window.ParsleyValidator[method] = function () {
            var _window$Parsley;
            Utils.warnOnce("Accessing the method '".concat(method, "' through Validator is deprecated. Simply call 'window.Parsley.").concat(method, "(...)'"));
            return (_window$Parsley = window.Parsley)[method].apply(_window$Parsley, arguments);
        };
    });
    window.Parsley.UI = UI;
    window.ParsleyUI = {
        removeError: function removeError(instance, name, doNotUpdateClass) {
            var updateClass = true !== doNotUpdateClass;
            Utils.warnOnce("Accessing UI is deprecated. Call 'removeError' on the instance directly. Please comment in issue 1073 as to your need to call this method.");
            return instance.removeError(name, {
                updateClass: updateClass
            });
        },
        getErrorsMessages: function getErrorsMessages(instance) {
            Utils.warnOnce("Accessing UI is deprecated. Call 'getErrorsMessages' on the instance directly.");
            return instance.getErrorsMessages();
        }
    };
    $.each('addError updateError'.split(' '), function (i, method) {
        window.ParsleyUI[method] = function (instance, name, message, assert, doNotUpdateClass) {
            var updateClass = true !== doNotUpdateClass;
            Utils.warnOnce("Accessing UI is deprecated. Call '".concat(method, "' on the instance directly. Please comment in issue 1073 as to your need to call this method."));
            return instance[method](name, {
                message: message,
                assert: assert,
                updateClass: updateClass
            });
        };
    });
    if (false !== window.ParsleyConfig.autoBind) {
        $(function () {
            if ($('[data-parsley-validate]').length) $('[data-parsley-validate]').parsley();
        });
    }
    var o = $({});
    var deprecated = function deprecated() {
        Utils.warnOnce("Parsley's pubsub module is deprecated; use the 'on' and 'off' methods on parsley instances or window.Parsley");
    };

    function adapt(fn, context) {
        if (!fn.parsleyAdaptedCallback) {
            fn.parsleyAdaptedCallback = function () {
                var args = Array.prototype.slice.call(arguments, 0);
                args.unshift(this);
                fn.apply(context || o, args);
            };
        }
        return fn.parsleyAdaptedCallback;
    }
    var eventPrefix = 'parsley:';

    function eventName(name) {
        if (name.lastIndexOf(eventPrefix, 0) === 0) return name.substr(eventPrefix.length);
        return name;
    }
    $.listen = function (name, callback) {
        var context;
        deprecated();
        if ('object' === _typeof(arguments[1]) && 'function' === typeof arguments[2]) {
            context = arguments[1];
            callback = arguments[2];
        }
        if ('function' !== typeof callback) throw new Error('Wrong parameters');
        window.Parsley.on(eventName(name), adapt(callback, context));
    };
    $.listenTo = function (instance, name, fn) {
        deprecated();
        if (!(instance instanceof Field) && !(instance instanceof Form)) throw new Error('Must give Parsley instance');
        if ('string' !== typeof name || 'function' !== typeof fn) throw new Error('Wrong parameters');
        instance.on(eventName(name), adapt(fn));
    };
    $.unsubscribe = function (name, fn) {
        deprecated();
        if ('string' !== typeof name || 'function' !== typeof fn) throw new Error('Wrong arguments');
        window.Parsley.off(eventName(name), fn.parsleyAdaptedCallback);
    };
    $.unsubscribeTo = function (instance, name) {
        deprecated();
        if (!(instance instanceof Field) && !(instance instanceof Form)) throw new Error('Must give Parsley instance');
        instance.off(eventName(name));
    };
    $.unsubscribeAll = function (name) {
        deprecated();
        window.Parsley.off(eventName(name));
        $('form,input,textarea,select').each(function () {
            var instance = $(this).data('Parsley');
            if (instance) {
                instance.off(eventName(name));
            }
        });
    };
    $.emit = function (name, instance) {
        var _instance;
        deprecated();
        var instanceGiven = instance instanceof Field || instance instanceof Form;
        var args = Array.prototype.slice.call(arguments, instanceGiven ? 2 : 1);
        args.unshift(eventName(name));
        if (!instanceGiven) {
            instance = window.Parsley;
        }
        (_instance = instance).trigger.apply(_instance, _toConsumableArray(args));
    };
    $.extend(true, Parsley, {
        asyncValidators: {
            'default': {
                fn: function fn(xhr) {
                    return xhr.status >= 200 && xhr.status < 300;
                },
                url: false
            },
            reverse: {
                fn: function fn(xhr) {
                    return xhr.status < 200 || xhr.status >= 300;
                },
                url: false
            }
        },
        addAsyncValidator: function addAsyncValidator(name, fn, url, options) {
            Parsley.asyncValidators[name] = {
                fn: fn,
                url: url || false,
                options: options || {}
            };
            return this;
        }
    });
    Parsley.addValidator('remote', {
        requirementType: {
            '': 'string',
            'validator': 'string',
            'reverse': 'boolean',
            'options': 'object'
        },
        validateString: function validateString(value, url, options, instance) {
            var data = {};
            var ajaxOptions;
            var csr;
            var validator = options.validator || (true === options.reverse ? 'reverse' : 'default');
            if ('undefined' === typeof Parsley.asyncValidators[validator]) throw new Error('Calling an undefined async validator: `' + validator + '`');
            url = Parsley.asyncValidators[validator].url || url;
            if (url.indexOf('{value}') > -1) {
                url = url.replace('{value}', encodeURIComponent(value));
            } else {
                data[instance.element.getAttribute('name') || instance.element.getAttribute('id')] = value;
            }
            var remoteOptions = $.extend(true, options.options || {}, Parsley.asyncValidators[validator].options);
            ajaxOptions = $.extend(true, {}, {
                url: url,
                data: data,
                type: 'GET'
            }, remoteOptions);
            instance.trigger('field:ajaxoptions', instance, ajaxOptions);
            csr = $.param(ajaxOptions);
            if ('undefined' === typeof Parsley._remoteCache) Parsley._remoteCache = {};
            var xhr = Parsley._remoteCache[csr] = Parsley._remoteCache[csr] || $.ajax(ajaxOptions);
            var handleXhr = function handleXhr() {
                var result = Parsley.asyncValidators[validator].fn.call(instance, xhr, url, options);
                if (!result)
                    result = $.Deferred().reject();
                return $.when(result);
            };
            return xhr.then(handleXhr, handleXhr);
        },
        priority: -1
    });
    Parsley.on('form:submit', function () {
        Parsley._remoteCache = {};
    });
    Base.prototype.addAsyncValidator = function () {
        Utils.warnOnce('Accessing the method `addAsyncValidator` through an instance is deprecated. Simply call `Parsley.addAsyncValidator(...)`');
        return Parsley.addAsyncValidator.apply(Parsley, arguments);
    };
    Parsley.addMessages('en', {
        defaultMessage: "This value seems to be invalid.",
        type: {
            email: "This value should be a valid email.",
            url: "This value should be a valid url.",
            number: "This value should be a valid number.",
            integer: "This value should be a valid integer.",
            digits: "This value should be digits.",
            alphanum: "This value should be alphanumeric."
        },
        notblank: "This value should not be blank.",
        required: "This value is required.",
        pattern: "This value seems to be invalid.",
        min: "This value should be greater than or equal to %s.",
        max: "This value should be lower than or equal to %s.",
        range: "This value should be between %s and %s.",
        minlength: "This value is too short. It should have %s characters or more.",
        maxlength: "This value is too long. It should have %s characters or fewer.",
        length: "This value length is invalid. It should be between %s and %s characters long.",
        mincheck: "You must select at least %s choices.",
        maxcheck: "You must select %s choices or fewer.",
        check: "You must select between %s and %s choices.",
        equalto: "This value should be the same.",
        euvatin: "It's not a valid VAT Identification Number."
    });
    Parsley.setLocale('en');

    function InputEvent() {
        var _this = this;
        var globals = window || global;
        _extends(this, {
            isNativeEvent: function isNativeEvent(evt) {
                return evt.originalEvent && evt.originalEvent.isTrusted !== false;
            },
            fakeInputEvent: function fakeInputEvent(evt) {
                if (_this.isNativeEvent(evt)) {
                    $(evt.target).trigger('input');
                }
            },
            misbehaves: function misbehaves(evt) {
                if (_this.isNativeEvent(evt)) {
                    _this.behavesOk(evt);
                    $(document).on('change.inputevent', evt.data.selector, _this.fakeInputEvent);
                    _this.fakeInputEvent(evt);
                }
            },
            behavesOk: function behavesOk(evt) {
                if (_this.isNativeEvent(evt)) {
                    $(document).off('input.inputevent', evt.data.selector, _this.behavesOk).off('change.inputevent', evt.data.selector, _this.misbehaves);
                }
            },
            install: function install() {
                if (globals.inputEventPatched) {
                    return;
                }
                globals.inputEventPatched = '0.0.3';
                for (var _i = 0, _arr = ['select', 'input[type="checkbox"]', 'input[type="radio"]', 'input[type="file"]']; _i < _arr.length; _i++) {
                    var selector = _arr[_i];
                    $(document).on('input.inputevent', selector, {
                        selector: selector
                    }, _this.behavesOk).on('change.inputevent', selector, {
                        selector: selector
                    }, _this.misbehaves);
                }
            },
            uninstall: function uninstall() {
                delete globals.inputEventPatched;
                $(document).off('.inputevent');
            }
        });
    }
    var inputevent = new InputEvent();
    inputevent.install();
    return Parsley;
})));