<div class="language-switcher">
    <select onchange="window.location.href=this.value" class="language-dropdown">
        <option value="{{ route('locale.switch', ['lang' => 'en']) }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧</option>
        <option value="{{ route('locale.switch', ['lang' => 'id']) }}" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>🇮🇩</option>
    </select>
</div>

{{-- <div class="language-toggler">
    <span class="lang-option {{ app()->getLocale() === 'en' ? 'active' : '' }}" data-lang="en">🇬🇧</span>
    <span class="lang-option {{ app()->getLocale() === 'id' ? 'active' : '' }}" data-lang="id">🇮🇩</span>
  </div>
   --}}
  

{{-- <div class="language-switcher form-check form-switch">
    <label class="form-check-label d-flex align-items-end" for="language-switcher">
        <input type="checkbox"
               class="form-check-input"
               id="language-switcher"
               onchange="switchLanguage()"
               {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
        <span class="switch-label">
            {{ app()->getLocale() == 'en' ? 'EN' : 'ID' }}
        </span>
    </label>
</div>

<script>
    function switchLanguage() {
        // Tentukan bahasa berdasarkan status checkbox
        const lang = document.getElementById('language-switcher').checked ? 'en' : 'id';

        // Bangun URL dengan parameter lang
        const url = `{{ url('language') }}/${lang}`;

        // Redirect ke URL
        window.location.href = url;
    }
</script>

<style>
    .language-switcher .form-check-input {
        position: relative;
        width: 50px;
        height: 24px;
        cursor: pointer;
    }

    .language-switcher .switch-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        font-weight: bold;
        pointer-events: none;
    }

    .form-check-input:checked + .switch-label::before {
        content: 'EN';
    }

    .form-check-input:not(:checked) + .switch-label::before {
        content: 'ID';
    }

    .switch-label::before {
        content: '';
        display: inline-block;
        font-size: 14px;
    }
</style> --}}