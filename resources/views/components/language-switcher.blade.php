<div class="language-switcher">
    <select onchange="window.location.href=this.value" class="language-dropdown">
        <option value="{{ route('locale.switch', ['lang' => 'en']) }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧</option>
        <option value="{{ route('locale.switch', ['lang' => 'id']) }}" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>🇮🇩</option>
    </select>
</div>