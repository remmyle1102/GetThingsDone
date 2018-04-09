<template>
    <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
        <div class="mb-6">
            <h1 class="text-grey-darkest">Get Things Done</h1>
            <div class="flex mt-4">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
                       v-model="newTask" @keyup.enter="addTask" placeholder="Add Task">
                <button class="flex-no-shrink p-2 border-2 rounded text-teal border-teal hover:text-white hover:bg-teal"
                        @click="addTask" :disabled="newTask.length === 0">Add
                </button>
            </div>
        </div>
        <div class="max-h-screen-1/2 overflow-y-scroll">
            <task-item v-for="(task, index) in tasks" :key="task.id" :task="task" :index="index"></task-item>
            <div v-show="tasks.length === 0">
                <p class="w-full text-center text-grey-dark">There are no tasks</p>
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