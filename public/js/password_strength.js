document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('registerPassword');
    const confirmation = document.getElementById('registerPasswordConfirmation');
    const text = document.getElementById('doctorRegisterStrengthText');
    const bars = [1, 2, 3, 4].map(i => document.getElementById('doctorRegisterBar' + i));

    if (!password || !text || bars.some(b => !b)) return;

    const colors = { 1: '#e58c8c', 2: '#e4b36e', 3: '#9dc87b', 4: '#62b9a4' };
    const labels = { 1: 'ضعيفة', 2: 'متوسطة', 3: 'جيدة', 4: 'قوية جدًا' };

    function score(value) {
        let s = 0;
        if (value.length >= 8) s++;
        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) s++;
        if (/[0-9]/.test(value)) s++;
        if (/[^A-Za-z0-9]/.test(value)) s++;
        return s;
    }

    function update() {
        const value = password.value;
        const s = value ? Math.max(1, score(value)) : 0;

        bars.forEach((bar, i) => {
            bar.style.background = i < s ? colors[s] : '#e7eeee';
        });

        text.textContent = s ? labels[s] : 'قوة كلمة المرور';
    }

    function checkMatch() {
        if (!confirmation) return;
        if (!confirmation.value) {
            confirmation.style.borderColor = '';
            return;
        }
        confirmation.style.borderColor =
            confirmation.value === password.value ? '#9dc8b8' : '#dc8a8a';
    }

    password.addEventListener('input', () => {
        update();
        checkMatch();
    });

    confirmation?.addEventListener('input', checkMatch);

    update();
});
