'use strict';

// MAP SETTINGS
var initMap = function () {
	var _ref = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(mapArg, arrayOfPins) {
		var manyMaps = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

		var element, zoomIn, latcord, loncord, imgpath, windowWidth, mapScrolling, centercords, map, img, mainmarkermarker, onMarkerLoad, _hidemarkers, _panTo, _doPan, markers, triggers, panPath, panQueue, STEPS, $hreftoMap, $map;

		return regeneratorRuntime.wrap(function _callee$(_context) {
			while (1) {
				switch (_context.prev = _context.next) {
				case 0:
					element = mapArg, zoomIn = parseFloat(element.getAttribute('data-zoom')), latcord = parseFloat(element.getAttribute('data-lat')), loncord = parseFloat(element.getAttribute('data-lon')), imgpath = element.getAttribute('data-icon'), windowWidth = $(window).width(), mapScrolling = true, centercords = { lat: latcord, lng: loncord };

					if (windowWidth < 992) {
						mapScrolling = false;
					}
					if (manyMaps) {
						latcord = arrayOfPins.lat;
						loncord = arrayOfPins.lng;
						centercords = { lat: latcord, lng: loncord };
					}
					map = new google.maps.Map(element, {
						zoom: zoomIn,
						center: centercords,
						fullscreenControl: true,
						scrollwheel: mapScrolling,
						mapTypeControl: false,
						scaleControl: false,
						streetViewControl: false,
						gestureHandling: 'cooperative',
						zoomControlOptions: {
							position: google.maps.ControlPosition.RIGHT_CENTER
						},
						styles: [{
							'featureType': 'administrative',
							'elementType': 'all',
							'stylers': [{
								'saturation': '-100'
							}]
						}, {
							'featureType': 'administrative.province',
							'elementType': 'all',
							'stylers': [{
								'visibility': 'off'
							}]
						}, {
							'featureType': 'landscape',
							'elementType': 'all',
							'stylers': [{
								'saturation': -100
							}, {
								'lightness': 65
							}, {
								'visibility': 'on'
							}]
						}, {
							'featureType': 'poi',
							'elementType': 'all',
							'stylers': [{
								'saturation': -100
							}, {
								'lightness': '50'
							}, {
								'visibility': 'simplified'
							}]
						}, {
							'featureType': 'road',
							'elementType': 'all',
							'stylers': [{
								'saturation': '-100'
							}]
						}, {
							'featureType': 'road.highway',
							'elementType': 'all',
							'stylers': [{
								'visibility': 'simplified'
							}]
						}, {
							'featureType': 'road.arterial',
							'elementType': 'all',
							'stylers': [{
								'lightness': '30'
							}]
						}, {
							'featureType': 'road.local',
							'elementType': 'all',
							'stylers': [{
								'lightness': '40'
							}]
						}, {
							'featureType': 'transit',
							'elementType': 'all',
							'stylers': [{
								'saturation': -100
							}, {
								'visibility': 'simplified'
							}]
						}, {
							'featureType': 'water',
							'elementType': 'geometry',
							'stylers': [{
								'hue': '#ffff00'
							}, {
								'lightness': -25
							}, {
								'saturation': -97
							}]
						}, {
							'featureType': 'water',
							'elementType': 'labels',
							'stylers': [{
								'lightness': -25
							}, {
								'saturation': -100
							}]
						}]
					});
					img = {
						url: imgpath,
						// This marker is 20 pixels wide by 32 pixels high.
						size: new google.maps.Size(35, 56),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(8.8, 28),
						scaledSize: new google.maps.Size(17.5, 28)
					};
					mainmarkermarker = new google.maps.Marker({
						position: centercords,
						map: map,
						icon: img,
						zIndex: 99999
					});

					if ($(element).hasClass('map-elem-near')) {
						onMarkerLoad = function onMarkerLoad(json) {
							var markerarr = [];
							mainmarkermarker.setMap(null);
							for (var i = 0; i < json.length; i++) {
								// Current object
								var obj = json[i];
								var imgType = {
									url: imgpath,
									// This marker is 20 pixels wide by 32 pixels high.
									size: new google.maps.Size(17.5, 28),
									origin: new google.maps.Point(0, 0),
									anchor: new google.maps.Point(8.8, 28),
									scaledSize: new google.maps.Size(17.5, 28)
									// Adding a new marker for the object
								};var pos = new google.maps.LatLng(obj.lat, obj.lng);
								markerarr.push(pos);
								var marker = new MarkerWithLabel({
									position: new google.maps.LatLng(obj.lat, obj.lng),
									title: obj.title,
									map: map,
									icon: imgType,
									zIndex: 999999,
									labelContent: '<div id="content">' + '<div class="siteNotice">' + '<div class="map_adress">' + obj.name + '</div>' + '<div class="map_tell">' + obj.tell + '</div>' + '<div class="map_date">' + obj.dates + '</div>' + '</div>' + '</div>',
									labelAnchor: new google.maps.Point(0, 0),
									labelClass: 'labels'
								});
								markers.push(marker);
								google.maps.event.addListener(marker, 'click', function (e) {
									_hidemarkers(markers);
									this.set('labelClass', 'labels place_open');
								});
							} // end loop
							google.maps.event.addListener(map, 'click', function (e) {
								if (!$(e.target).hasClass('labels')) {
									_hidemarkers(markers);
								}
							});
						};

						_hidemarkers = function _hidemarkers(array) {
							for (var i = 0; i < array.length; i++) {
								var cur = array[i];
								cur.set('labelClass', 'labels');
							}
						};

						_panTo = function _panTo(newLat, newLng) {
							if (panPath.length > 0) {
								panQueue.push([newLat, newLng]);
							} else {
								// Lets compute the points we'll use
								panPath.push('LAZY SYNCRONIZED LOCK');
								var curLat = map.getCenter().lat();
								var curLng = map.getCenter().lng();
								var dLat = (newLat - curLat) / STEPS;
								var dLng = (newLng - curLng) / STEPS;
								for (var i = 0; i < STEPS; i++) {
									panPath.push([curLat + dLat * i, curLng + dLng * i]);
								}
								panPath.push([newLat, newLng]);
								panPath.shift();
								setTimeout(_doPan, 20);
							}
						};

						_doPan = function _doPan() {
							var next = panPath.shift();
							if (next != null) {
								map.panTo(new google.maps.LatLng(next[0], next[1]));
								setTimeout(_doPan, 10);
							} else {
								var queued = panQueue.shift();
								if (queued != null) {
									_panTo(queued[0], queued[1]);
								}
							}
						};

						markers = [];

						onMarkerLoad(arrayOfPins);
						triggers = $(element).closest('.contact-section').find('.js-map-trigger');
						panPath = []; // путь

						panQueue = []; // очередь

						STEPS = 10; // шаг

						triggers.each(function () {
							var _ = $(this),
								    ind = _.index();
							_.on('click', function () {
								_.addClass('active').siblings().removeClass('active');
								var lat = markers[ind].position.lat(),
									    lng = markers[ind].position.lng();
								_panTo(lat, lng);
							});
						});

						if ($('.hrefToMap').length) {
							$hreftoMap = $('.hrefToMap'), $map = $('.map');

							$hreftoMap.on('click', function (e) {
								e.preventDefault();
								$('html, body').animate({ scrollTop: $map.offset().top - 200 }, '500');
								_panTo($(e.target).data('lat'), $(e.target).data('lng'));
								_hidemarkers(markers);
								markers[$(e.target).data('marker')].set('labelClass', 'labels place_open');
							});
						}
					}

				case 7:
				case 'end':
					return _context.stop();
				}
			}
		}, _callee, this);
	}));

	return function initMap(_x2, _x3) {
		return _ref.apply(this, arguments);
	};
}();

//END MAP SETTINGS

function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

window.onload = function () {

	if ($('.map').length) {
		initMap($('.map')[0], arrayOfPins);
	}
};document.addEventListener('DOMContentLoaded', function () {
	var _this2 = this;

	var addCountSlider = function () {
		var _ref7 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee7($item) {
			return regeneratorRuntime.wrap(function _callee7$(_context7) {
				while (1) {
					switch (_context7.prev = _context7.next) {
					case 0:
						$item.filter(function () {
							var count = parseInt($(this).find('.slick-dots li').length);
							$(this).append('<div class="advanced-slider__count-slides">' + count + '</div>');
						});

					case 1:
					case 'end':
						return _context7.stop();
					}
				}
			}, _callee7, this);
		}));

		return function addCountSlider(_x7) {
			return _ref7.apply(this, arguments);
		};
	}();

	var stars = function () {
		var _ref9 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee9() {
			var parent, items, target;
			return regeneratorRuntime.wrap(function _callee9$(_context9) {
				while (1) {
					switch (_context9.prev = _context9.next) {
					case 0:
						parent = $('.js-stars'), items = parent.find('.star-item'), target = parent.find('.rev-hidden');


						items.on('mouseover', function () {
							items.removeClass('star-hover');
							$(this).addClass('star-hover');
							$(this).prevAll().addClass('star-hover');
						});
						items.on('mouseout', function () {
							items.removeClass('star-hover');
						});

						items.click(function (e) {
							$(this).closest('.star-wrapper').removeClass('has-error').addClass('has-success').find('.form-error').remove();
							e.preventDefault();
							var num = parseInt($(this).data("num")),
								    i = 1;
							for (i = 1; i <= num; i++) {
								$("#rev-star-" + i).addClass('active');
							}
							for (i = num + 1; i <= 5; i++) {
								$("#rev-star-" + i).removeClass('active');
							}
							target.val(num);

							return false;
						});

					case 4:
					case 'end':
						return _context9.stop();
					}
				}
			}, _callee9, this);
		}));

		return function stars() {
			return _ref9.apply(this, arguments);
		};
	}();

	var $html = $('html'),
	    $mobileMenu = $('.mobile-menu');

	if ($('.dropdown-list').length) {
		var dropdownList = $('.dropdown-list');
		dropdownList.filter(_asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2() {
			var _this = this;

			return regeneratorRuntime.wrap(function _callee2$(_context2) {
				while (1) {
					switch (_context2.prev = _context2.next) {
					case 0:
						$(this).on('click', function () {
							$(_this).toggleClass('active');
						});

					case 1:
					case 'end':
						return _context2.stop();
					}
				}
			}, _callee2, this);
		})));
		$(document).mouseup(function () {
			var _ref3 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3(e) {
				return regeneratorRuntime.wrap(function _callee3$(_context3) {
					while (1) {
						switch (_context3.prev = _context3.next) {
						case 0:
							if (!dropdownList.is(e.target) && dropdownList.has(e.target).length === 0) {
								dropdownList.removeClass('active');
							}

						case 1:
						case 'end':
							return _context3.stop();
						}
					}
				}, _callee3, this);
			}));

			return function (_x4) {
				return _ref3.apply(this, arguments);
			};
		}());
	}

	$('.search__form').filter(function () {
		$(this).find('.search__input').filter(function () {
			$(this).on('focusout', function () {
				$(this).parent().removeClass('focusing');
				$(this).parent().removeClass('active');
			});
			$(this).on('focusin', function () {
				$(this).parent().addClass('focusing');
				if (!$(this).hasClass('active')) {
					$(this).parent().addClass('active');
				}
			});
		});
	});

	$('.header-nav-wrapper__burger, .mobile-menu__overlay').on('click', function () {
		$('.header-nav-wrapper__burger').toggleClass('active');
		$html.toggleClass('remodal-is-locked');
		$mobileMenu.toggleClass('active');
	});

	$('.dropdown-menu__image').on('click', function () {
		var _self = $(this).parent().parent().parent(),
		    a = _self.find('.dropdown-menu__inner-items-wrapper').height();
		if (!_self.hasClass('active')) {
			_self.find('.dropdown-menu__items-wrapper').height(a);
		} else {
			_self.find('.dropdown-menu__items-wrapper').height(0);
		}
		_self.toggleClass('active');
	});

	function createDoubleSlider($item) {
		$item.filter(function () {
			var firstSlider = $(this).find('.first-slider'),
			    secondSlider = $(this).find('.second-slider'),
			    firstSliderOptions = {
					accessibility: false,
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					dots: true,
					asNavFor: '#' + secondSlider.attr('id')
				},
			    secondSliderOptions = {
					accessibility: false,
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: '#' + firstSlider.attr('id'),
					dots: false,
					arrows: false,
					focusOnSelect: true
				};

			firstSlider.slick(firstSliderOptions);
			secondSlider.slick(secondSliderOptions);
		});
	}

	if ($('.double-slider').length) {
		createDoubleSlider($('.double-slider'));
	}

	function createSlider($item) {
		$item.filter(function () {
			$(this).slick({
				accessibility: false,
				slidesToShow: 3,
				slidesToScroll: 3,
				arrows: true,
				dots: false
			});
		});
	}

	if ($('.to-up').length) {
		$('.to-up').on('click', function () {
			var _ref4 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee4(event) {
				return regeneratorRuntime.wrap(function _callee4$(_context4) {
					while (1) {
						switch (_context4.prev = _context4.next) {
						case 0:
							event.preventDefault();
							$('html, body').animate({ scrollTop: 0 }, '500');

						case 2:
						case 'end':
							return _context4.stop();
						}
					}
				}, _callee4, this);
			}));

			return function (_x5) {
				return _ref4.apply(this, arguments);
			};
		}());
	}

	if ($('.underline--animation').length) {
		$('.underline--animation').on('click', function () {
			var _ref5 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee5(e) {
				var hr;
				return regeneratorRuntime.wrap(function _callee5$(_context5) {
					while (1) {
						switch (_context5.prev = _context5.next) {
						case 0:
							e.preventDefault();
							hr = $(this).data('href');

							$('html').animate({ scrollTop: $('[data-id="' + hr + '"]').offset().top - 140 }, '501');

						case 3:
						case 'end':
							return _context5.stop();
						}
					}
				}, _callee5, this);
			}));

			return function (_x6) {
				return _ref5.apply(this, arguments);
			};
		}());
	}

	if ($('.long-slider').length) {
		createSlider($('.long-slider'));
	}

	if ($('.slider-adapt').length) {
		var windowWidth = $(window).width();
		$('.slider-adapt').filter(_asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee6() {
			return regeneratorRuntime.wrap(function _callee6$(_context6) {
				while (1) {
					switch (_context6.prev = _context6.next) {
					case 0:
						if ($(this).data('adapt') >= windowWidth) {
							createSlider($(this));
						}

					case 1:
					case 'end':
						return _context6.stop();
					}
				}
			}, _callee6, this);
		})));
	}

	if ($('.advanced-slider').length) {
		addCountSlider($('.advanced-slider'));
	}

	if ($('.advanced-list').length) {
		$('.advanced-list').filter(function () {
			var advancedList = $(this).find('.advanced-list__list'),
			    currentHeight = advancedList.height(),
			    fullHeight = advancedList.children().height() + parseInt(advancedList.children().css('margin-top')) + parseInt(advancedList.children().css('margin-bottom'));
			advancedList.css('height', currentHeight);
			$(this).find('.advanced-list-trigger').on('click', _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee8() {
				var $_self;
				return regeneratorRuntime.wrap(function _callee8$(_context8) {
					while (1) {
						switch (_context8.prev = _context8.next) {
						case 0:
							$_self = $(this);

							if (advancedList.hasClass('active')) {
								$_self.text($_self.data('text-show') || 'Показать');
								advancedList.css('height', currentHeight);
								setTimeout(function () {
									advancedList.removeClass('active');
								}, 200);
							} else {
								$_self.text($_self.data('text-hide') || 'Свернуть');
								advancedList.css('height', fullHeight);
								advancedList.addClass('active');
							}
							$(this).toggleClass('active');

						case 3:
						case 'end':
							return _context8.stop();
						}
					}
				}, _callee8, this);
			})));
		});
	}

	if ($(window).width() >= 767) {
		inView.offset(50);
		inView('.animateThis').on('enter', function (el) {
			$(el).addClass('animated ' + $(el).data('anim'));
		});
	}

	stars();

	if ($('.form__formFocus').length) {

		var form = $('.form__formFocus');

		form.filter(function () {

			var _self = $(this),
			    alone = _self.data('multifile') == false ? false : true;

			$.validate({
				form: _self,
				modules: 'html5, security, file',
				lang: $('body').data('lang'),
				addValidClassOnAll: true,
				validateOnBlur: true, // disable validation when input looses focus
				errorMessagePosition: 'bottom',
				scrollToTopOnError: false,
				onSuccess: function onSuccess($form) {
					$.ajax({
						type: 'POST',
						url: $form.attr('action'),
						data: $form.serialize(),
						success: function success(data) {
							data = JSON.parse(data);
							var modalSuccess = $(data.modal).remodal();
							modalSuccess.open();
							_self[0].reset();
						}
					});
					return false;
				}
			});
		});
	}

	var offset = 250,
	    duration = 500;
	$(window).scroll(function () {
		if ($(this).scrollTop() > offset) {
			$('.to-up').fadeIn(duration);
		} else {
			$('.to-up').fadeOut(duration);
		}
	});

	var minH = function minH() {
		$('.page__content').css('min-height', $(window).height() - $('#footer').height() - 80);
	};

	minH();

	$(window).on('resize', _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee10() {
		return regeneratorRuntime.wrap(function _callee10$(_context10) {
			while (1) {
				switch (_context10.prev = _context10.next) {
				case 0:
					minH();

				case 1:
				case 'end':
					return _context10.stop();
				}
			}
		}, _callee10, _this2);
	})));

	if (getCookie('ageConfirmed') !== 'true') {
		$('html').addClass('remodal-is-locked');
		$('.age-confirm').show();
	}

	$('.age-confirm__btn').on('click', function (e) {
		e.preventDefault();
		if ($('#age-confirm').is(':checked')) {
			setCookie('ageConfirmed', 'true', '/', { expires: 604800000 /* 1 week in seconds */ });
			$('.age-confirm').fadeOut();
			$('html').removeClass('remodal-is-locked');
		}
	});
});

function setCookie(name, value, path, options) {
	options = options || {};

	var expires = options.expires;

	if (typeof expires === "number" && expires) {
		var d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	}
	if (expires && expires.toUTCString) {
		options.expires = expires.toUTCString();
	}

	value = encodeURIComponent(value);

	var updatedCookie = name + "=" + value;
	updatedCookie += "; " + "path=" + path;
	for (var propName in options) {
		updatedCookie += "; " + propName;
		var propValue = options[propName];
		if (propValue !== true) {
			updatedCookie += "=" + propValue;
		}
	}

	document.cookie = updatedCookie;
}

function getCookie(name) {
	var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}