window.addEventListener('load', function () {
  const tabBlocks = document.querySelectorAll('.tabs');

  [...tabBlocks].forEach(function (tabBlock) {
    const tabButtons = tabBlock.querySelectorAll('.tabs__button');
    const tabPanels = tabBlock.querySelectorAll('.tabs__panel');

    if (tabButtons.length && tabPanels.length) {
      tabButtons.forEach(function (label, i) {
        tabButtons[i].setAttribute('id', 'tablabel_' + i);
        tabPanels[i].setAttribute('aria-labelledby', 'tablabel_' + i);
      });

      const toggleEvent = function (e) {
        if (e.type === 'click') {
          return true;
        } else if (e.type === 'keydown') {
          const code = e.charCode || e.keyCode;
          if (code === 32 || code === 13) {
            return true;
          }
          if (code === 37) {
            return 'move-left';
          }
          if (code === 39) {
            return 'move-right';
          }
          return false;
        } else {
          return false;
        }
      };

      const toggleTabClasses = function (button, i) {
        const activeTab = tabBlock.querySelector('.tabs__button--active');
        const activePanel = tabBlock.querySelector('.tabs__panel--active');

        activeTab.classList.remove('tabs__button--active');
        activeTab.setAttribute('aria-selected', false);

        button.classList.add('tabs__button--active');
        button.setAttribute('aria-selected', true);

        activePanel.classList.remove('tabs__panel--active');
        activePanel.setAttribute('aria-selected', false);
        activePanel.setAttribute('hidden', true);

        tabPanels[i].classList.add('tabs__panel--active');
        tabPanels[i].setAttribute('aria-selected', true);
        tabPanels[i].removeAttribute('hidden');
      };

      const moveTabFocus = function (i) {
        var label = tabButtons[i];
        var labelId = label.getAttribute('id');
        var control = document.getElementById(labelId);
        control.focus();
        toggleTabClasses(label, i);
      }

      var total = tabButtons.length;
      tabButtons.forEach(function (button, i) {
        if (button.classList.contains('active')) {
          tabPanels[i].classList.toggle('active');
        }

        button.addEventListener('click', function (e) {
          if (toggleEvent(e) === true) {
            toggleTabClasses(button, i);
          }
        });
        button.addEventListener('keydown', function (e) {
          if (toggleEvent(e) === true) {
            toggleTabClasses(button, i);
          }
          if (toggleEvent(e) === 'move-right' && i < total) {
            moveTabFocus(i + 1);
          }
          if (toggleEvent(e) === 'move-left' && i > 0) {
            moveTabFocus(i - 1);
          }
        });
      });
    }
  });
});
