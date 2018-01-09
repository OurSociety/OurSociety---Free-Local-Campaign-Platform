/**
 * Polyfill for input type="month" with no dependencies.
 *
 * @link https://gist.github.com/JordanReiter/2367756a5f93c25d5b8412ed5eb11eed
 */

(function () {
  let monthInputs = document.querySelectorAll('input[type="month"]'),
    checkDateInput = document.createElement('input'),
    dateSupported = false,
    months = [],
    lang = document.documentElement.lang || navigator.language,
    DEFAULT_SPAN = 5;

  if (monthInputs.length === 0 || monthInputs[0].type === 'month') {
    // browser supports month input; no need for polyfill
    return true;
  }
  checkDateInput.setAttribute('type', 'date')
  dateSupported = 'date' === checkDateInput.type;

  function makeRangeArray(from, to) {
    let result = [], idx;
    if (!to) {
      to = from;
      from = 0;
    }
    for (idx = from; idx < to; idx += 1) {
      result.push(idx);
    }
    return result;
  }

  if (!dateSupported) {
    // initialize months
    makeRangeArray(12).forEach( // generate size 12 array and loop over
      function (_, idx) {
        let dt = new Date(1900, idx, 15);
        months[idx] = dt.toLocaleString(
          lang,
          {'month': "long"}
        )
      }
    );
  }

  function createMonthDropdown(selected) {
    let monthDropdown = document.createElement('select');
    selected = selected || new Date().getUTCMonth();
    selected = selected.getUTCMonth ? selected.getUTCMonth() : selected;
    months.forEach(function (monthName, monthIdx) {
      let opt = document.createElement('option');
      opt.value = String(monthIdx + 1);
      opt.text = monthName;
      if (monthIdx === selected) {
        opt.setAttribute('selected', 'selected');
      }
      monthDropdown.appendChild(opt);
    });
    return monthDropdown;
  }

  function createYearDropdown(selected, dropdownYears) {
    let yearDropdown = document.createElement('select');
    selected = selected || new Date().getUTCFullYear();
    selected = selected.getUTCFullYear ? selected.getUTCFullYear() : selected;
    dropdownYears.forEach(function (year) {
      let opt = document.createElement('option');
      opt.value = year;
      opt.text = year;
      if (year === selected) {
        opt.setAttribute('selected', 'selected');
      }
      yearDropdown.appendChild(opt);
    });
    return yearDropdown;
  }

  function getYears(startYear, endYear, yearSpan) {
    let years;
    yearSpan = yearSpan || DEFAULT_SPAN // by default, get 10 years before & after
    if (!startYear && !endYear) {
      startYear = new Date().getUTCFullYear() - yearSpan;
      endYear = new Date().getUTCFullYear() + yearSpan;
    } else {
      startYear = startYear || endYear - (yearSpan * 2);
      endYear = endYear || startYear + (yearSpan * 2);
    }
    if (startYear > endYear) {
      throw new Error("Invalid inputs; end year must be less than start year");
    }
    years = makeRangeArray(startYear, endYear + 1);
    return years;
  }

  function getLastDayOfMonth(dt) {
    dt = dt instanceof Date ? dt : new Date(Date.parse(String(dt)));
    dt.setUTCMonth(dt.getUTCMonth() + 1)
    dt = new Date(dt - 1);
    return dt.getUTCDate();
  }

  let YEAR_MONTH_PATT = /^\d\d\d\d-\d\d$/;
  monthInputs.forEach(function (monthInput) {
    let initial = monthInput.value,
      yearEl, monthEl, dateEl,
      yearSpan = parseInt(monthInput.dataset.yearSpan),
      yearDropdown = monthInput.dataset.yearDropdown,
      minMonth = monthInput.min,
      maxMonth = monthInput.max,
      startYear, endYear, years;
    if (minMonth) {
      startYear = parseInt(minMonth.split('-')[0], 10);
    }
    if (maxMonth) {
      endYear = parseInt(maxMonth.split('-')[0], 10);
    }
    if (typeof yearDropdown !== 'undefined') {
      yearDropdown = !(
        yearDropdown === false ||
        yearDropdown.toLowerCase() === 'false'
      )
    }
    if (initial && YEAR_MONTH_PATT.test(initial)) {
      initial += '-01';
    }
    initial = initial && new Date(Date.parse(initial));
    initial = (initial && initial.getTime && !isNaN(initial.getTime())) ? initial : new Date();
    monthInput.dataset.year = initial.getUTCFullYear();
    monthInput.dataset.month = initial.getUTCMonth() + 1;
    years = getYears(startYear, endYear, yearSpan);
    if (dateSupported) {
      dateEl = document.createElement('input');
      dateEl.setAttribute('type', 'date');
      dateEl.monthInputTarget = monthInput;
      dateEl.monthInputType = 'date';
      if (monthInput.min) {
        if (monthInput.min.split('-').length >= 2) {
          dateEl.setAttribute(
            'min',
            monthInput.min + '-01'
          );
        } else {
          dateEl.setAttribute('min', monthInput.min + '-01-01');
        }
      }
      if (monthInput.max) {
        if (monthInput.max.split('-').length >= 2) {
          dateEl.setAttribute(
            'max',
            monthInput.max + '-' + getLastDayOfMonth(monthInput.max)
          );
        } else {
          dateEl.setAttribute('max', monthInput.max + '-12-31');
        }
      }
      if (monthInput.value) {
        dateEl.value = (
          monthInput.value + '-01'
        );
      }
      monthInput.parentNode.insertBefore(dateEl, monthInput);
    } else {
      if (yearDropdown === false) {
        yearEl = document.createElement('input');
        yearEl.setAttribute('type', 'number');
        if (startYear) {
          yearEl.setAttribute('min', startYear);
        }
        if (endYear) {
          yearEl.setAttribute('max', endYear);
        }
        yearEl.setAttribute('step', 1);
        if (initial) {
          yearEl.value = String(initial.getUTCFullYear());
        }
      } else {
        yearEl = createYearDropdown(initial, years);
      }
      yearEl.monthInputTarget = monthInput;
      yearEl.monthInputType = 'year';
      monthEl = createMonthDropdown(initial);
      monthEl.monthInputTarget = monthInput;
      monthEl.monthInputType = 'month';
      monthInput.parentNode.insertBefore(monthEl, monthInput);
      monthInput.parentNode.insertBefore(
        document.createTextNode(' '),
        monthInput
      );
      monthInput.parentNode.insertBefore(yearEl, monthInput);
    }
    // monthInput.style.display = 'none';
  });

  function updateValue(input) {
    let date, newValue, monthDisplay;
    if (input.dataset.date) {
      date = new Date(Date.parse(input.dataset.date));
      newValue = (
        date.getUTCFullYear() +
        '-' +
        (date.getUTCMonth() + 1).toString().padStart(2, '0')
      );
    } else {
      newValue = input.dataset.year + '-' + input.dataset.month.toString().padStart(2, '0');
    }
    if (input.max && newValue > input.max) {
      monthDisplay = months[parseInt(input.max.split('-')[1])];
      if (monthDisplay) {
        alert(
          "You cannot choose a date later than " +
          monthDisplay + ", " +
          input.max.split('-')[0]
        )
      } else {
        alert(
          "You cannot choose a year greater than " + input.max.split('-')[0]
        )
      }
      return false;
    } else if (input.min && newValue < input.min) {
      alert("Value cannot be less than " + input.min);
      return false;
    }
    input.value = newValue;
    return true;
  }

  document.addEventListener('focus', function (event) {
    let focused = event.target;
    if (focused.monthInputTarget) {
      focused.dataset.storedValue = focused.value;
      if (typeof focused.selectedIndex !== 'undefined') {
        focused.dataset.storedIndex = focused.selectedIndex;
      }
    }
  }, true);

  document.addEventListener('change', function (event) {
    let changed = event.target;
    if (changed.monthInputTarget && changed.monthInputType) {
      changed.monthInputTarget.dataset[changed.monthInputType] = changed.value;
      if (!updateValue(changed.monthInputTarget)) {
        if (changed.dataset.storedIndex) {
          changed.selectedIndex = changed.dataset.storedIndex;
        } else if (changed.dataset.storedValue) {
          changed.value = changed.dataset.storedValue;
        }
        changed.monthInputTarget.dataset[changed.monthInputType] = changed.dataset.storedValue;
        changed.focus();
      } else {
        changed.dataset.storedValue = changed.value;
        if (typeof changed.selectedIndex !== 'undefined') {
          changed.dataset.storedIndex = changed.selectedIndex;
        }
      }
    }
    return true;
  }, true);

}())
