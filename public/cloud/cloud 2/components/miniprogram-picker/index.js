module.exports =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/* 参考文档: https://github.com/IceApriler/miniprogram-picker */

function isExist(field) {
  return field !== null && field !== undefined;
}

Component({
  externalClasses: ['picker-class'],
  /**
   * 组件的属性列表
   */
  properties: {
    // 初始化时，是否需要自动返回结果给开发者
    autoSelect: {
      type: Boolean,
      value: false
    },
    // 源数组，sourceData有几维，Picker就可以有几阶
    sourceData: {
      type: Array,
      value: [],
      observer: 'sourceDataChange'
    },
    // 阶数
    steps: {
      type: Number,
      value: 1
    },
    // 展示数据的字段名称
    shownFieldName: {
      type: String,
      value: 'name'
    },
    // 子节点名称，
    subsetFieldName: {
      type: String,
      value: 'subset'
    },
    // 其他需要返回的字段
    otherNeedFieldsName: {
      type: Array,
      value: []
    },
    // 选择了第n列后，是否将大于n的列的选择值自动初始化为0
    initColumnSelectedIndex: {
      type: Boolean,
      value: false
    },
    // 默认选中项的下标数组
    defaultIndex: {
      type: Array,
      value: []
    },
    // 默认选中项的值数组
    defaultValue: {
      type: Array,
      value: []
    },
    // 默认选中项的值数组的唯一字段，用来和源数组进行比对
    defaultValueUniqueField: {
      type: String,
      value: ''
    },
    // 是否禁用
    disabled: {
      type: Boolean,
      value: false
    }
  },

  /**
   * 组件的初始数据
   */
  data: {
    // Picker当前所选择的索引数组 => 比如:[0, 0, 2]，表示第一列选择第0项，第二列选择第0项，第三列选择第2项。
    multiIndex: {
      type: Array,
      value: []
    },
    // Picker当前所展示的数组 => 比如:[['河北', '山东'], ['石家庄', '保定'], ['桥西区', '裕华区', '长安区']]。
    multiArray: {
      type: Array,
      value: []
    },
    // 用户点击确定后，所选择的值数组 => 比如:
    // [{name: '河北', id: '3110'}, {name: '石家庄', id: '3110xx'}, {name: '长安区', id: '3110xxx'}]。
    selectedArray: {
      type: Array,
      value: []
    }
  },

  /**
   * 组件的方法列表
   */
  methods: {
    /**
     * 监听源数组更新变化
     *
     * @param {Array} newSourceData 源数组，newSourceData有几维，Picker就可以有几阶。
     */
    sourceDataChange: function sourceDataChange(newSourceData) {
      var _data = this.data,
          shownFieldName = _data.shownFieldName,
          subsetFieldName = _data.subsetFieldName,
          steps = _data.steps;
      // 源数组更新，则需要更新multiIndex、multiArray

      var multiIndex = [];
      var multiArray = [];
      newSourceData = this.checkSourceData(newSourceData);

      var defaultIndex = this.getDefaultIndex(newSourceData);
      var handle = function handle() {
        var source = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
        var columnIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

        // 当前遍历Picker的第columnIndex列，
        // 当columnIndex = 0时，source表示sourceData，其它则表示子集subset
        var _multiArrayColumn0 = [];

        source.forEach(function (item, index) {
          if (columnIndex === 0) {
            // newSourceData的第0维要单独处理，最后unshift到multiArray中
            _multiArrayColumn0.push(item[shownFieldName]);
          }

          if (isExist(item[shownFieldName]) && index === (defaultIndex[columnIndex] || 0)) {
            // 选中的索引和值，默认取每列的第0个
            multiIndex.push(index);

            if (columnIndex < steps - 1) {
              if (isExist(item[subsetFieldName])) {
                // 开始处理下一维的数据
                var _subsetArr = item[subsetFieldName].map(function (sub) {
                  return sub[shownFieldName];
                });
                multiArray.push(_subsetArr);
                handle(item[subsetFieldName], columnIndex + 1);
              }
            }
          }
        });

        if (columnIndex === 0) {
          multiArray.unshift(_multiArrayColumn0);
        }
      };

      handle(newSourceData);

      this.setData({
        multiIndex: multiIndex,
        multiArray: multiArray
      });

      if (this.data.autoSelect) {
        this.processData();
      }
    },

    /**
     * 获取默认值index
     * @param {Array} newSourceData 源数组
     */
    getDefaultIndex: function getDefaultIndex(newSourceData) {
      var _this = this;

      var _data2 = this.data,
          defaultIndex = _data2.defaultIndex,
          defaultValue = _data2.defaultValue,
          defaultValueUniqueField = _data2.defaultValueUniqueField,
          steps = _data2.steps,
          subsetFieldName = _data2.subsetFieldName;

      if (defaultIndex.length) {
        return defaultIndex;
      } else if (defaultValue.length) {
        if (defaultValue.length !== steps) {
          this.consoleError(new Error('你设置的"defaultValue"字段阶数与"steps"不符，请修改后再试。'));
          return [];
        } else if (!defaultValueUniqueField) {
          this.consoleError(new Error('你设置了"defaultValue"字段, 但是没有设置defaultValueUniqueField，这将无法识别默认选项，请补充后再试。'));
          return [];
        } else {
          defaultValue.forEach(function (def, key) {
            if (!def[defaultValueUniqueField]) {
              _this.consoleError(def, new Error('"defaultValue"\u4E2D\u7B2C' + key + '\u9879(\u4ECE0\u5F00\u59CB\u8BA1\u7B97)\u7684\u5BF9\u8C61\u4E2D\u7F3A\u5C11"' + defaultValueUniqueField + '"\u5B57\u6BB5'));
            }
          });

          var _defaultIndex = [];
          var handle = function handle() {
            var source = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
            var columnIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

            // 默认值
            _defaultIndex[columnIndex] = 0;

            source.forEach(function (item, index) {
              if (!item[defaultValueUniqueField]) {
                _this.consoleError(item, new Error('\u6E90\u6570\u7EC4\u7B2C' + columnIndex + '\u7EF4(\u4ECE0\u5F00\u59CB\u8BA1\u7B97)\u7684\u5BF9\u8C61\u4E2D\u7F3A\u5C11"' + defaultValueUniqueField + '"\u5B57\u6BB5'));
              } else if (defaultValue[columnIndex][defaultValueUniqueField] === item[defaultValueUniqueField]) {
                _defaultIndex[columnIndex] = index;

                if (columnIndex < steps - 1) {
                  if (item[subsetFieldName]) {
                    // 开始处理下一维的数据
                    handle(item[subsetFieldName], columnIndex + 1);
                  }
                }
              }
            });
          };
          handle(newSourceData);
          return _defaultIndex;
        }
      } else {
        return [];
      }
    },


    /**
     * 校验源数组是否正确
     *
     * @param {Array} sourceData 源数组
     */
    checkSourceData: function checkSourceData(sourceData) {
      var _this2 = this;

      var _data3 = this.data,
          shownFieldName = _data3.shownFieldName,
          subsetFieldName = _data3.subsetFieldName,
          steps = _data3.steps;

      var handle = function handle() {
        var source = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
        var columnIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

        // 当前遍历Picker的第columnIndex列，
        // 当columnIndex = 0时，source表示sourceData，其它则表示子集subset
        if (!source.length) {
          var temp = {};
          temp[shownFieldName] = '';
          temp[subsetFieldName] = [];
          source.push(temp);
        }
        return source.map(function (item) {
          if (!isExist(item[shownFieldName])) {
            _this2.consoleError(item, new Error('\u6E90\u6570\u7EC4\u7B2C' + columnIndex + '\u7EF4(\u4ECE0\u5F00\u59CB\u8BA1\u7B97)\u7684\u5BF9\u8C61\u4E2D\u7F3A\u5C11"' + shownFieldName + '"\u5B57\u6BB5'));
            item[shownFieldName] = '';
          }

          // 有shownFieldName字段才会去遍历subsetFieldName字段
          if (columnIndex < steps - 1) {
            if (!isExist(item[subsetFieldName])) {
              _this2.consoleError(item, new Error('\u6E90\u6570\u7EC4\u7B2C' + columnIndex + '\u7EF4(\u4ECE0\u5F00\u59CB\u8BA1\u7B97)\u7684\u5BF9\u8C61\u4E2D\u7F3A\u5C11"' + subsetFieldName + '"\u5B57\u6BB5'));
            }
            // 开始处理下一维的数据
            item[subsetFieldName] = handle(item[subsetFieldName], columnIndex + 1);
          }
          return item;
        });
      };
      return handle(sourceData);
    },


    /**
     * 用户点击了确认。
     *
     * @param {Object} e 事件对象，具体参考微信小程序api。
     * @param {Array} e.detail.value 用户选择的下标数组。
     */
    pickerChange: function pickerChange(e) {
      // console.log('picker发送选择改变，携带值为', e.detail.value)

      this.setData({
        multiIndex: e.detail.value
      });
      this.processData();
    },


    /**
     * 处理最终数据，将返回给开发者。
     *
     */
    processData: function processData() {
      var _this3 = this;

      var _data4 = this.data,
          sourceData = _data4.sourceData,
          shownFieldName = _data4.shownFieldName,
          subsetFieldName = _data4.subsetFieldName,
          otherNeedFieldsName = _data4.otherNeedFieldsName,
          multiIndex = _data4.multiIndex;

      var selectedArray = [];

      var handle = function handle() {
        var source = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
        var columnIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

        source.forEach(function (item, index) {
          if (index === multiIndex[columnIndex]) {
            var selectedItem = {};
            selectedItem[shownFieldName] = item[shownFieldName];
            otherNeedFieldsName.forEach(function (key) {
              selectedItem[key] = item[key];
            });
            selectedArray.push(selectedItem);
            if (columnIndex < _this3.data.steps - 1) {
              handle(item[subsetFieldName], columnIndex + 1);
            }
          }
        });
      };
      handle(sourceData);

      this.setData({
        selectedArray: selectedArray
      });

      var detail = {
        selectedIndex: this.data.multiIndex,
        selectedArray: this.data.selectedArray
      };
      this.triggerEvent('change', detail);
    },


    /**
     * 用户滚动了某一列。
     *
     * @param {Object} e 事件对象，具体参考微信小程序api。
     */
    pickerColumnChange: function pickerColumnChange(e) {
      var _data5 = this.data,
          shownFieldName = _data5.shownFieldName,
          subsetFieldName = _data5.subsetFieldName,
          multiArray = _data5.multiArray,
          sourceData = _data5.sourceData,
          steps = _data5.steps,
          initColumnSelectedIndex = _data5.initColumnSelectedIndex;
      var multiIndex = this.data.multiIndex;
      var _e$detail = e.detail,
          column = _e$detail.column,
          changeIndex = _e$detail.value;

      // console.log(`修改了Picker的第${column}列(从0开始计算)，选中了第${changeIndex}个值(从0开始计算)`)

      // multiIndex变化了，所以也要同步更新multiArray

      multiIndex[column] = changeIndex;

      if (initColumnSelectedIndex) {
        // 每次重置之后的index为0，但是有bug，待定。 => 经检查，是编辑器的问题，真机上是没有问题的。
        var _multiIndex = multiIndex.map(function (item, index) {
          if (column >= index) {
            return item;
          } else {
            return 0;
          }
        });
        multiIndex = _multiIndex;
      }

      var handle = function handle() {
        var source = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
        var columnIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

        // 当前遍历第 columnIndex 列
        source.forEach(function (item, index) {
          if (index === multiIndex[columnIndex]) {
            if (columnIndex < steps - 1) {
              if (!item[subsetFieldName]) {
                item[subsetFieldName] = [];
              }
              var multiArrayItem = item[subsetFieldName].map(function (sub) {
                return sub[shownFieldName];
              });
              // 从第1列开始，才有可能变化
              multiArray[columnIndex + 1] = multiArrayItem;

              handle(item[subsetFieldName], columnIndex + 1);
            }
          }
        });
      };
      handle(sourceData);

      this.setData({
        multiArray: multiArray,
        multiIndex: multiIndex
      });
      this.triggerEvent('columnchange', e);
    },

    /**
     * 用户点击了取消触发
     * @param {Object} e 事件对象
     */
    pickerCancel: function pickerCancel(e) {
      this.triggerEvent('cancel', e);
    },

    /**
     * 绑定console.error
     * @param  {...any} arg 打印参数
     */
    consoleError: function consoleError() {
      var _console;

      (_console = console).error.apply(_console, arguments);
      console.warn('参考文档：https://github.com/IceApriler/miniprogram-picker');
    }
  },
  attached: function attached() {
    if (this.data.autoSelect) {
      this.processData();
    }
  }
});

/***/ })
/******/ ]);