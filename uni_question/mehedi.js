let questionCount = 0;

document.getElementById('addQuestionBtn').addEventListener('click', function() {
    questionCount++;
    const container = document.getElementById('questionsContainer');

    const div = document.createElement('div');
    div.classList.add('question-block');
    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">X</button>
        <label>Question ${questionCount}:</label>
        <textarea name="question_text[]" rows="2" required></textarea>

        <label>Option 1:</label>
        <input type="text" name="option1[]" required>

        <label>Option 2:</label>
        <input type="text" name="option2[]" required>

        <label>Option 3:</label>
        <input type="text" name="option3[]" required>

        <label>Option 4:</label>
        <input type="text" name="option4[]" required>

        <label>Correct Option:</label>
        <select name="correct_option[]" required>
            <option value="">Select Correct Option</option>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
            <option value="option4">Option 4</option>
        </select>
    `;
    container.appendChild(div);
});
