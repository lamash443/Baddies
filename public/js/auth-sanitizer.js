/**
 * Kenyan Baddies Club - Authentication Input Sanitizer & Limits Enforcer
 * Enforces character limits, allowed punctuations, and eradicates invalid symbols/emojis.
 * Displays toast alerts on disallowed characters without redirecting or navigating away.
 */
(function () {
  'use strict';

  var EMOJI_REGEX = /[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{1F700}-\u{1F7FF}\u{1F800}-\u{1F8FF}\u{1F900}-\u{1F9FF}\u{1FA00}-\u{1FA6F}\u{1FA70}-\u{1FAFF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{2300}-\u{23FF}\u{2B50}\u{2B55}\u{203C}\u{2049}\u{2122}\u{2139}\u{2194}-\u{2199}\u{21A9}-\u{21AA}\u{231A}-\u{231B}\u{23E9}-\u{23EC}\u{23F0}\u{23F3}\u{25AA}-\u{25AB}\u{25FB}-\u{25FE}\u{2614}-\u{2615}\u{2648}-\u{2653}\u{267F}\u{2693}\u{26A1}\u{26AA}-\u{26AB}\u{26BD}-\u{26BE}\u{26C4}-\u{26C5}\u{26CE}\u{26D4}\u{26EA}\u{26F2}-\u{26F3}\u{26F5}\u{26FA}\u{26FD}\u{2702}\u{2705}\u{2708}-\u{270D}\u{270F}\u{2712}\u{2714}\u{2716}\u{271D}\u{2721}\u{2728}\u{2733}-\u{2734}\u{2744}\u{2747}\u{274C}\u{274E}\u{2753}-\u{2755}\u{2757}\u{2763}-\u{2764}\u{2795}-\u{2797}\u{27A1}\u{27B0}\u{27BF}\u{2934}-\u{2935}\u{2B05}-\u{2B07}\u{3030}\u{303D}\u{3297}\u{3299}]/gu;

  var lastToastTime = 0;
  function triggerNameWarningToast() {
    var now = Date.now();
    if (now - lastToastTime < 2500) return; // Debounce so user isn't spammed while typing
    lastToastTime = now;

    if (typeof window.showSiteToast === 'function') {
      window.showSiteToast(
        'Invalid Name',
        'Please enter a valid full name. Numbers, emojis, and special symbols are not allowed.',
        'warning'
      );
    }
  }

  /**
   * Check if a name contains any eradicated characters:
   * Digits (0-9), emojis, or symbols (!@#$%^&*()_+={}[];:"<>,/?\|`~)
   */
  window.nameHasDisallowedChars = function (val) {
    if (!val) return false;
    if (/[0-9]/.test(val)) return true;
    if (EMOJI_REGEX.test(val)) return true;
    if (/[^a-zA-Z\s\-\'\.]/.test(val)) return true;
    return false;
  };

  /**
   * Full Name sanitizer:
   * - Max 40 characters
   * - Allowed: letters (a-z, A-Z), single spaces, hyphens (-), apostrophes ('), and periods (.)
   * - Eradicates all numbers, emojis, and all other punctuation
   */
  window.sanitizeAuthName = function (val) {
    if (!val) return '';
    var hadDisallowed = window.nameHasDisallowedChars(val);

    var clean = val.replace(EMOJI_REGEX, '');
    clean = clean.replace(/[^a-zA-Z\s\-\'\.]/g, '');
    clean = clean.replace(/^[\s\-\'\.]+/, ''); // no leading punctuation or space
    clean = clean.replace(/\s{2,}/g, ' ');     // collapse multiple spaces
    clean = clean.replace(/\-{2,}/g, '-');     // collapse multiple hyphens
    clean = clean.replace(/\'{2,}/g, "'");     // collapse multiple apostrophes
    clean = clean.replace(/\.{2,}/g, '.');     // collapse multiple periods
    clean = clean.slice(0, 40);

    if (hadDisallowed) {
      triggerNameWarningToast();
    }

    return clean;
  };

  /**
   * Email sanitizer:
   * - Max 40 characters
   * - Allowed: letters, digits, and specific email punctuation: @, ., _, -, +
   * - Eradicates spaces, quotes, brackets, slashes, other symbols, and emojis
   */
  window.sanitizeAuthEmail = function (val) {
    if (!val) return '';
    var clean = val.replace(EMOJI_REGEX, '');
    clean = clean.replace(/[^a-zA-Z0-9@._\-+]/g, '');
    var firstAt = clean.indexOf('@');
    if (firstAt !== -1) {
      clean = clean.substring(0, firstAt + 1) + clean.substring(firstAt + 1).replace(/@/g, '');
    }
    clean = clean.replace(/\.{2,}/g, '.');
    return clean.slice(0, 40);
  };

  /**
   * Password on signup & confirmation sanitizer:
   * - Max 12 characters (and min 8)
   * - Allowed: alphanumeric + safe password symbols
   */
  window.sanitizeAuthSignupPassword = function (val) {
    if (!val) return '';
    var clean = val.replace(EMOJI_REGEX, '');
    clean = clean.replace(/[^a-zA-Z0-9@$#&!%*?._\-+=~]/g, '');
    return clean.slice(0, 12);
  };

  /**
   * Password on login sanitizer:
   * - Max 64 characters
   */
  window.sanitizeAuthLoginPassword = function (val) {
    if (!val) return '';
    var clean = val.replace(EMOJI_REGEX, '');
    clean = clean.replace(/[\s\'\"\`\<\>]/g, '');
    return clean.slice(0, 64);
  };

  function setSanitizedValue(input, cleanVal) {
    if (input.value === cleanVal) return;
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var prevLen = input.value.length;
    input.value = cleanVal;
    if (start !== null && end !== null) {
      var diff = prevLen - cleanVal.length;
      var newPos = Math.max(0, start - (diff > 0 ? diff : 0));
      try {
        input.setSelectionRange(newPos, newPos);
      } catch (err) {}
    }
  }

  function sanitizeInputElement(input) {
    if (!input || input.tagName !== 'INPUT') return;

    var id = input.id || '';
    var name = input.name || '';
    var type = (input.type || '').toLowerCase();

    // 1. Full Name fields
    if (id === 'reg-name' || id === 'name' || name === 'name') {
      if (!input.getAttribute('maxlength')) input.setAttribute('maxlength', '40');
      var cleanName = window.sanitizeAuthName(input.value);
      setSanitizedValue(input, cleanName);
    }
    // 2. Email fields
    else if (type === 'email' || id.includes('email') || name === 'email') {
      if (!input.getAttribute('maxlength')) input.setAttribute('maxlength', '40');
      var cleanEmail = window.sanitizeAuthEmail(input.value);
      setSanitizedValue(input, cleanEmail);
    }
    // 3. Signup / Reset Password & Confirmation fields
    else if (
      id === 'reg-password' ||
      id === 'reg-password-confirm' ||
      id === 'password_confirmation' ||
      (id === 'password' && (document.getElementById('password_confirmation') || document.getElementById('reg-password-confirm') || document.getElementById('req-length')))
    ) {
      if (!input.getAttribute('maxlength')) input.setAttribute('maxlength', '12');
      var cleanPw = window.sanitizeAuthSignupPassword(input.value);
      setSanitizedValue(input, cleanPw);
    }
    // 4. Login Password fields
    else if (id === 'login-password' || (id === 'password' && type === 'password')) {
      if (!input.getAttribute('maxlength')) input.setAttribute('maxlength', '64');
      var cleanLoginPw = window.sanitizeAuthLoginPassword(input.value);
      setSanitizedValue(input, cleanLoginPw);
    }
  }

  // Real-time input listener (as user types or pastes)
  document.addEventListener('input', function (e) {
    sanitizeInputElement(e.target);
  }, true);

  // Paste listener for immediate sanitization
  document.addEventListener('paste', function (e) {
    setTimeout(function () {
      sanitizeInputElement(e.target);
    }, 10);
  }, true);

  // Blur listener for final trimming
  document.addEventListener('blur', function (e) {
    var el = e.target;
    if (!el || el.tagName !== 'INPUT') return;

    var id = el.id || '';
    var name = el.name || '';
    var type = (el.type || '').toLowerCase();

    if (id === 'reg-name' || id === 'name' || name === 'name') {
      el.value = el.value.replace(/[\s\-\'\.]+$/, '').trim();
    } else if (type === 'email' || id.includes('email') || name === 'email') {
      el.value = el.value.toLowerCase().trim();
    }
  }, true);

  // Intercept form submissions to guarantee invalid names are never submitted
  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form || form.tagName !== 'FORM') return;

    var nameInput = form.querySelector('#reg-name, #name, input[name="name"]');
    if (nameInput) {
      var val = (nameInput.value || '').trim();

      // Check for disallowed characters
      if (window.nameHasDisallowedChars(val)) {
        e.preventDefault();
        e.stopImmediatePropagation();
        triggerNameWarningToast();
        nameInput.focus();
        return false;
      }

      // Check min length
      if (val.length < 2) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (typeof window.showSiteToast === 'function') {
          window.showSiteToast('Invalid Name', 'Please enter your full name (at least 2 letters).', 'warning');
        }
        nameInput.focus();
        return false;
      }
    }
  }, true);

  // Apply on DOM ready
  document.addEventListener('DOMContentLoaded', function () {
    var nameInputs = document.querySelectorAll('#reg-name, #name, input[name="name"]');
    nameInputs.forEach(function (el) { el.setAttribute('maxlength', '40'); });

    var emailInputs = document.querySelectorAll('#login-email, #reg-email, #email, input[type="email"], input[name="email"]');
    emailInputs.forEach(function (el) { el.setAttribute('maxlength', '40'); });

    var signupPwInputs = document.querySelectorAll('#reg-password, #reg-password-confirm, #password_confirmation');
    signupPwInputs.forEach(function (el) { el.setAttribute('maxlength', '12'); });

    var loginPwInputs = document.querySelectorAll('#login-password');
    loginPwInputs.forEach(function (el) { el.setAttribute('maxlength', '64'); });
  });
})();
