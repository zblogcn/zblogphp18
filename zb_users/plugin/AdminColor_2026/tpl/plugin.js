(function() {

  const bar = document.getElementById('acPresetBar');
  const fields = ['NormalColor', 'BoldColor', 'LightColor', 'HighColor', 'AntiColor', 'Square'];

  // 查找输入框及对应的颜色显示元素
  function findField(name) {
    const input = document.querySelector('input[name="' + name + '"]');
    let span = null;
    if (input && input.nextElementSibling && input.nextElementSibling.classList.contains('ac-color-span')) {
      span = input.nextElementSibling;
    }
    return { input: input, span: span };
  }

  // 应用预置方案到输入框及颜色显示
  function applyPreset(preset) {
    if (!Object.hasOwn(preset, 'Square')) {
      preset.Square = preset.NormalColor;
    }
    fields.forEach(function(key) {
      const f = findField(key);
      if (f.input) {
        f.input.value = preset[key];
      }
      if (f.span) {
        f.span.style.backgroundColor = preset[key];
      }
    });
    highlightActive(preset);
  }

  // 检查当前输入框值是否匹配预置方案
  function presetMatchesCurrent(preset) {
    if (!Object.hasOwn(preset, 'Square')) {
      preset.Square = preset.NormalColor;
    }
    return fields.every(function(key) {
      const f = findField(key);
      if (!f.input) return false;
      const expected = preset[key];
      return f.input.value.toLowerCase() === expected.toLowerCase();
    });
  }

  // 高亮当前匹配的预置方案
  function highlightActive(preset) {
    const cards = bar.querySelectorAll('.ac-preset-item');
    cards.forEach(function(card) {
      card.classList.remove('ac-active');
    });
    const match = bar.querySelector('[data-bold="' + preset.BoldColor + '"][data-normal="' + preset.NormalColor + '"]');
    if (match) {
      match.classList.add('ac-active');
    }
  }

  // 渲染预置方案卡片
  function renderPresets() {
    presets.forEach(function(preset, idx) {
      const title = preset.Title && preset.Title.trim() ? preset.Title : '方案 ' + (idx + 1);
      const card = document.createElement('div');
      card.className = 'ac-preset-item';
      card.setAttribute('data-bold', preset.BoldColor);
      card.setAttribute('data-normal', preset.NormalColor);
      card.setAttribute('data-light', preset.LightColor);
      card.setAttribute('data-high', preset.HighColor);
      card.setAttribute('data-anti', preset.AntiColor);
      card.setAttribute('data-square', preset.Square || preset.NormalColor);

      const square = document.createElement('span');
      square.className = 'ac-preset-square';
      square.style.backgroundColor = preset.Square || preset.NormalColor;

      const titleEl = document.createElement('div');
      titleEl.className = 'ac-preset-title';
      titleEl.textContent = title;

      const dots = document.createElement('div');
      dots.className = 'ac-preset-dots';

      ['BoldColor', 'NormalColor', 'LightColor', 'HighColor', 'AntiColor'].forEach(function(key) {
        const dot = document.createElement('span');
        dot.className = 'ac-color-dot';
        dot.style.backgroundColor = preset[key];
        dots.appendChild(dot);
      });

      card.appendChild(square);
      card.appendChild(titleEl);
      card.appendChild(dots);

      card.addEventListener('click', function() {
        applyPreset(preset);
      });

      card.addEventListener('mouseenter', function() {
        setExpanded(card);
      });

      bar.appendChild(card);
    });

    bar.addEventListener('mouseleave', function() {
      clearExpanded();
    });
  }

  // 展开指定卡片，收起其他卡片
  function setExpanded(activeCard) {
    const cards = bar.querySelectorAll('.ac-preset-item');
    cards.forEach(function(card) {
      if (card === activeCard) {
        card.classList.add('ac-expanded');
      } else {
        card.classList.remove('ac-expanded');
      }
    });
  }

  // 收起所有卡片
  function clearExpanded() {
    const cards = bar.querySelectorAll('.ac-preset-item');
    cards.forEach(function(card) {
      card.classList.remove('ac-expanded');
      card.classList.remove('ac-hidden');
    });
  }

  // 初始化高亮当前方案
  function initActive() {
    const active = presets.find(presetMatchesCurrent);
    if (active) {
      highlightActive(active);
    }
  }

  renderPresets();
  initActive();
})();
