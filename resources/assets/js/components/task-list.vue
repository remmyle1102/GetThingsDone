<template>
    <section class="is-info">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-6 is-offset-3">
                    <h1 class="title">Get Things Done</h1>
                    <input class="input is-success" autofocus v-model="newTask" @keyup.enter="addTask"
                           placeholder="What needs to be done?">
                    <div class="card card-table is-success" v-show="tasks.length" v-cloak>
                        <table class="table is-striped" id="table">
                            <task-item class="" v-for="(task, index) in tasks" :key="task.id" :task="task"
                                       :index="index">
                            </task-item>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                    t.updateTask(details);
                })

                bus.$on('remove-task', function (details) {
                    t.removeTask(details);
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
            addTask() {
                const t = this;

                if (t.newTask.length > 0) {
                    t.createTask(t.newTask);
                    t.newTask = '';
                }
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
        },
        components: {
            taskItem
        }
    }
</script>
