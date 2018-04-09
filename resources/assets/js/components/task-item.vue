<template>
    <div class="">
        <div class="flex items-center w-full" v-show="state.edit === false">
            <input type="checkbox" class="mr-2" v-model="data.finished" @click="updateTask">
            <p class="w-auto"
               :class="data.finished ? 'line-through text-green' : 'text-grey-darkest cursor-pointer hover:text-black hover:font-bold'"
               @click="startEdit">{{task.text}}</p>
            <button class="flex-no-shrink p-2 ml-auto border-2 rounded text-red border-red hover:text-white hover:bg-red"
                    @click="remove(index)">Remove
            </button>
        </div>
        <div class="flex items-center w-full" v-show="state.edit === true">
            <input class="appearance-none border rounded w-full py-2 px-3 mr-2 text-black" v-model="data.text"
                   @keyup.enter="updateTask" placeholder="Update Todo">
            <button class="flex-no-shrink p-2 ml-2 border-2 rounded text-teal border-teal hover:text-white hover:bg-teal"
                    @click="updateTask" :disabled="data.text.length === 0">Update
            </button>
            <button class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red"
                    @click="cancelEdit">Cancel
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['task', 'index'],
        data() {
            return {
                state: {
                    edit: false,
                },
                data: {
                    text: '',
                    finished: false,
                }
            }
        },
        mounted() {
            const t = this;

            t.data.text = t.task.text;
            t.data.finished = t.task.finished;
        },
        methods: {
            updateTask() {
                const t = this;

                t.$nextTick(() => {
                    bus.$emit('update-task', {data: t.data, index: t.index, id: t.task.id});
                });

                t.state.edit = false;
            },
            remove() {
                const t = this;

                bus.$emit('remove-task', {index: t.index, id: t.task.id});
            },
            startEdit() {
                const t = this;

                if (t.data.finished === false) {
                    t.state.edit = true;
                }
            },
            cancelEdit() {
                const t = this;

                t.state.edit = false;
                t.data.text = t.task.text;
            }
        }
    }
</script>

<style scoped>

</style>