<div class="bg-gray-50 rounded-lg p-6 mb-4 question-block">
    <div class="flex justify-between items-center mb-4">
        <h4 class="text-xl font-bold text-gray-800">سؤال {{ (int) $questionIndex + 1 }}</h4>
        <button type="button" class="text-red-500 hover:text-red-700 remove-question-btn">
            حذف السؤال
        </button>
    </div>
    
    <input type="hidden" name="questions[{{ $questionIndex }}][id]" value="{{ $question->id ?? '' }}">
    
    <div class="mb-4">
        <label for="question-{{ $questionIndex }}-text" class="block text-gray-700 font-semibold mb-2">نص السؤال</label>
        <textarea name="questions[{{ $questionIndex }}][question_text]" id="question-{{ $questionIndex }}-text" class="form-textarea w-full rounded-lg border-gray-300 shadow-sm" rows="3" required>{{ old('questions.'.$questionIndex.'.question_text', $question->question_text ?? '') }}</textarea>
    </div>
    
    <input type="hidden" name="questions[{{ $questionIndex }}][type]" value="multiple_choice">
    
    <h5 class="text-lg font-bold text-gray-800 mb-2">الخيارات</h5>
    <div class="space-y-3">
        @foreach ($question->choices ?? [null, null, null, null] as $choiceIndex => $choice)
            <div class="flex items-center space-x-2 choice-block">
                <input type="text" name="questions[{{ $questionIndex }}][choices][{{ $choiceIndex }}][text]" value="{{ old('questions.'.$questionIndex.'.choices.'.$choiceIndex.'.text', $choice->choice_text ?? '') }}" class="form-input flex-1 rounded-lg border-gray-300 shadow-sm" required>
                <input type="hidden" name="questions[{{ $questionIndex }}][choices][{{ $choiceIndex }}][id]" value="{{ $choice->id ?? '' }}">
                <label class="flex items-center space-x-1">
                    <input type="radio" name="questions[{{ $questionIndex }}][correct_choice]" value="{{ $choiceIndex }}" {{ old('questions.'.$questionIndex.'.correct_choice', $choice->is_correct ?? false ? $choiceIndex : '') == $choiceIndex ? 'checked' : '' }} class="form-radio text-blue-600">
                    <span class="text-sm">صحيح</span>
                </label>
            </div>
        @endforeach
    </div>
</div>