<template>
    <div class="container">
        <question :question="question"></question>
        <answerss :question="question"></answerss>
    </div>
</template>

<script>
import Question from "../components/Question.vue";
import Answerss from "../components/Answerss.vue";


export default {
    components: { Question, Answerss },
    props: ['question']
}
</script>
