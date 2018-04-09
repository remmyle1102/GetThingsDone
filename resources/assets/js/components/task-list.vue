<template>
    <div class="container">
        <h1 class="title">Get Things Done</h1>
        <div class="field ">
            <input class="input is-success is-inline-block" v-model="newTask" @keyup.enter="addTask"
                   placeholder="Add Task">
            <button class="button is-success is-outlined"
                        @click="addTask" :disabled="newTask.length === 0">Add
                </button>
        </div>
        <div class="">
            <task-item class="" v-for="(task, index) in tasks" :key="task.id" :task="task" :index="index"></task-item>
            <div class="" v-show="tasks.length === 0">
                <p class="">There are no tasks</p>
            </div>
        </div>
    </div>
</template>

<script>
    import taskItem from './task-item'

    export default {
        data() {
            return{
                tasks: [],
                newTask: '',
            }
        },
        created() {
            this.getTasks();
            this.initListeners();
        },
        methods: {
            initListeners() {
                const t = this;

                bus.$on('update-task', function (details) {
                    t.update(details);
                })

                bus.$on('remove-task', function (details) {
                    t.remove(details);
                })
            },
            getTasks() {
                const t = this;

                axios.get('/tasks')
                    .then(({data}) => {
                        t.tasks = data;
                    });
            },
            createTask(text) {
                const t = this;

                axios.post('/tasks', {text: text, finished: false})
                    .then(({data}) => {
                        t.tasks.unshift(data);
                    });
            },
            updateTask(details) {
                const t = this;

                axios.patch('/tasks/' + details.id, details.data)
                    .then(({data}) => {
                        t.tasks.splice(details.index, 1, data)
                    })
            },
            removeTask(details) {
                const t = this;
                axios.delete('/tasks/' + details.id)
                    .then(() => {
                        t.tasks.splice(details.index, 1)
                    })
            },
            addTask() {
                const t = this;

                if (t.newTask.length > 0) {
                    t.createTask(t.newTask);
                    t.newTask = '';
                }
            },
        },
        components: {
            taskItem
        }
    }
</script>

<style scoped>

</style>