// Splide
import Splide from '@splidejs/splide';
import {
  Grid
} from '@splidejs/splide-extension-grid';


// jQuery
(function ($) {
  'use strict';

  // PC/SP判定
  // スクロールイベント
  // リサイズイベント
  // スムーズスクロール

  /* ここから */
  var break_point = 640; //ブレイクポイント
  var mql = window.matchMedia('screen and (max-width: ' + break_point + 'px)'); //、MediaQueryListの生成
  var deviceFlag = mql.matches ? 1 : 0; // 0 : PC ,  1 : SP

  // pagetop
  var timer = null;
  var $pageTop = $('#pagetop');
  $pageTop.hide();

  /**
   * Functions
   */
  const headerFn = {
    addSubMenuAction: function ($this, deviceFlag) {
      $this.addClass('is-active');

      if (deviceFlag == 0) { // PC
        $this.next('.sub-menu').addClass('is-active');
      } else {
        $this.next('.sub-menu').slideDown();
      }
    },
    removeSubMenuAction: function ($this, deviceFlag) {
      $this.removeClass('is-active');

      if (deviceFlag == 0) { // PC
        $this.next('.sub-menu').removeClass('is-active');
      } else {
        $this.next('.sub-menu').slideUp();
      }
    },
    removeAll: function () {
      $('.js--headerSubMenuTrigger').removeClass('is-active');
      $('.c-header .sub-menu').removeClass('is-active');
      $('.c-header .sub-menu').slideUp();
      $('.js--headerMenuTrigger').removeClass('is-active');
      $('.c-header .link-list').removeClass('is-active');
      scrollOn();
    },
    addMenuAction: function ($this) {
      const menu = $this.siblings('.link-list');
      $this.addClass('is-active');
      menu.addClass('is-active');
      scrollOff();
    },
    removeMenuAction: function ($this) {
      const menu = $this.siblings('.link-list');
      $this.removeClass('is-active');
      menu.removeClass('is-active');
      scrollOn();
    }
  }

  // scroll controll
  var isScrollable = true;
  var winScroll;
  var getScrollPos = function () {
    if (!isScrollable) {
      return;
    }
    winScroll = window.scrollY || window.pageYOffset;
  }
  $(window).on('scroll', function () {
    getScrollPos();
  });
  getScrollPos();
  var scrollOff = function () {
    $('body').css({
      'cssText': 'position : fixed; top : ' + (-winScroll) + 'px !important; width: 100%;'
    });
    isScrollable = false;
  };
  var scrollOn = function () {
    $('body').css({
      'position': '',
      'top': ''
    });
    window.scrollTo(0, winScroll);
    isScrollable = true;
  };

  // スクロールイベント
  $(window).on('scroll touchmove', function () {

    // スクロール中か判定
    if (timer !== false) {
      clearTimeout(timer);
    }

    // 200ms後にフェードイン
    timer = setTimeout(function () {
      if ($(this).scrollTop() > 100) {
        $('#pagetop').fadeIn('normal');
      } else {
        $pageTop.fadeOut();
      }
    }, 200);

    var scrollHeight = $(document).height();
    var scrollPosition = $(window).height() + $(window).scrollTop();
    var footHeight = parseInt($('#footer').innerHeight());


    if (deviceFlag == 0) { // → PC
      if (scrollHeight - scrollPosition <= footHeight) {
        // 現在の下から位置が、フッターの高さの位置にはいったら
        $pageTop.css({
          'position': 'absolute',
          'bottom': footHeight
        });
      }
    } else { // → SP
      $pageTop.css({
        'position': 'fixed',
        'bottom': '20px'
      });
    }

    // header
    const headerHeight = $('.c-header').innerHeight();
    if ($(this).scrollTop() > headerHeight) {
      $('.c-header').addClass('is-shadow');
    }
    if ($(this).scrollTop() <= headerHeight) {
      $('.c-header').removeClass('is-shadow');
    }

  });


  // リサイズイベント

  var checkBreakPoint = function (mql) {
    deviceFlag = mql.matches ? 1 : 0; // 0 : PC ,  1 : SP
    // → PC
    if (deviceFlag == 0) {
      headerFn.removeAll();
    } else {
      // →SP
      headerFn.removeAll();
    }
    deviceFlag = mql.matches;
  }

  // ブレイクポイントの瞬間に発火
  mql.addListener(checkBreakPoint); //MediaQueryListのchangeイベントに登録

  // 初回チェック
  checkBreakPoint(mql);


  // スムーズスクロール
  // #で始まるアンカーをクリックした場合にスムーススクロール
  $('a[href^="#"]').on('click', function (e) {
    var speed = 500;
    // アンカーの値取得
    var href = $(this).attr('href');
    // 移動先を取得
    var target = $(href == '#' || href == '' ? 'html' : href);
    // 移動先を数値で取得
    var position = target.offset().top;

    // スムーススクロール lazyload対策で実際には２回スムーススクロール実行
    $.when(
      $("html, body").animate({
        scrollTop: position
      }, 400, "swing"),
      e.preventDefault(),
    ).done(function () {
      var diff = target.offset().top;
      if (diff === position) {} else {
        $("html, body").animate({
          scrollTop: diff
        }, 10, "swing");
      }
    });

    return false;
  });

  // ページ読み込み時の表示崩れを防ぐ
  $(function() {
    $('#wrapper').fadeIn(0);
  });

  // Splide
  $(function () {
    if ($('.splide-scroll-vertical')[0]) {
      new Splide('.splide-scroll-vertical', {
        arrows: false,
        wheel: true,
        direction: 'ttb',
        heightRatio: 0.5,
        breakpoints: {
          765: {
            heightRatio: 0.7,
          },
          640: {
            direction: 'ltr',
            height: 'auto',
            type: 'loop',
            wheel: false,
            autoplay: true,
            interval: 5000,
          }
        }
      }).mount();
    }

    if ($('.splide-scroll-side')[0]) {
      new Splide('.splide-scroll-side', {
        type: 'loop',
        arrows: false,
        perPage: 1,
        autoplay: true,
        interval: 5000,
        grid: {
          rows: 2,
          cols: 1,
          gap: {
            row: '48px',
          },
        },
        breakpoints: {
          1170: {
            grid: {
              rows: 1,
              cols: 2,
              gap: {
                col: '48px',
              },
            }
          },
          640: {
            grid: {
              rows: 1,
              cols: 1,
            }
          }
        }
      }).mount({
        Grid
      });
    }
  });

  // header
  $(function () {
    if ($('.js--headerSubMenuTrigger')[0]) {
      $('.js--headerSubMenuTrigger').on('click', function () {
        if ($(this).hasClass('is-active')) {
          headerFn.removeSubMenuAction($(this), deviceFlag);
        } else {
          headerFn.addSubMenuAction($(this), deviceFlag);
        }
      })
    }

    if ($('.js--headerMenuTrigger')[0]) {
      $('.js--headerMenuTrigger').on('click', function () {
        if ($(this).hasClass('is-active')) {
          headerFn.removeMenuAction($(this));
        } else {
          headerFn.addMenuAction($(this));
        }
      })
    }
  });

  // Tab
  $(function() {
    if($('.js--tab')[0]) {
      const triggers = $('.js--tab .tab-head button');
      const content = $('.js--tab .tab-content');

      function tabAction(index) {
        triggers.removeClass('is-active');
        triggers.eq(index).addClass('is-active');
        content.children().hide();
        content.children().eq(index).show();
      }

      if(triggers.hasClass('is-active') === false) {
        tabAction(0);
      }
      
      triggers.on('click', function() {
        tabAction(triggers.index(this));
      });
    }
  });

  // Toggle list
  $(function() {
    if($('.js--toggle_list_trigger')[0]) {
      $('.js--toggle_list_trigger').on('click', function() {
        $(this).toggleClass('is-active');
        $(this).next().slideToggle();
      })
    }
  });
})(jQuery);