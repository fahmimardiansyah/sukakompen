function showTab(role) {
    // Hides all tab contents
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });

    // Shows the selected tab content
    const activeTab = document.getElementById(role);
    activeTab.classList.add('active');

    // Change active class for tabs
    const buttons = document.querySelectorAll('.tabs .tab');
    buttons.forEach(button => {
        button.classList.remove('active');
    });

    // Mark the clicked tab as active
    const activeButton = document.querySelector(`.tabs .tab[onclick="showTab('${role}')"]`);
    activeButton.classList.add('active');
}
