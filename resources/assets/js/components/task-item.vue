<template>
        <tbody>
        <tr v-show="state.edit === false" class="is-success">
            <!--Checkbox -->
            <td width="5%">
                <div class="pretty p-switch p-fill">
                    <input type="checkbox" v-model="data.finished" @click="updateTask"/>
                    <div class="state p-success">
                        <label></label>
                    </div>
                </div>
            </td>
            <!--Things need to be done -->
            <td :class="data.finished ? 'finished-task' : '' " v-on:dblclick="startEdit">{{task.text}}</td>
            <!-- Remove Button -->
            <td width="5%">
                <a class="button is-danger is-outlined is-small" v-show="data.finished ===true">
                        <span class="icon is-small">
      <i class="fa fa-trash" @click="remove(index)"></i>
                        </span>
                </a>
            </td>
        </tr>
        <tr v-show="state.edit === true">
            <td width="5%">
            </td>
            <td id="tdEditTask">
                <input class="input is-success" v-focus v-model="data.text" id="inputEditTask" v-if="state.edit"
                       @keyup.enter="updateTask"
                       @blur="updateTask"
                       @keyup.esc="cancelEdit"
                       :disabled="data.text.length===0">
            </td>
        </tr>
        </tbody>

</template>
<script>
    export default {
        props: ['task', 'index'],
        directives: {
            focus: {
                // directive definition
                inserted: function (el) {
                    el.focus()
                }
            }
        },
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
                document.getElementById("inputEditTask").focus();
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