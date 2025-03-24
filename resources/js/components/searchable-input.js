// noinspection JSUnusedGlobalSymbols,JSUnresolvedReference

export default function searchableInput(){
    return {
        previous_value: null,
        value: $wire.entangle('{{$field->getStatePath()}}'),
        suggestions: [],
        selected_suggestion: 0,
        refresh_suggestions: function(){
            if(this.value === this.previous_value){
                return;
            }

            if(!this.value){
                this.suggestions = [];
                return;
            }

            this.previous_value = this.value;

            $wire.mountFormComponentAction('{{$field->getStatePath()}}', 'search', {value: this.value})
                .then(response => {
                    this.suggestions = response;
                    this.selected_suggestion = 0;
                });
        },
        set: function(item){
            if(item === undefined){
                return;
            }

            this.value = item.value;
            this.suggestions = [];
            $wire.mountFormComponentAction('{{$field->getStatePath()}}', 'item_selected', {item: item})
        },
        previous_suggestion(){
            this.selected_suggestion--;

            if(this.selected_suggestion < 0){
                this.selected_suggestion = 0;
            }
        },
        next_suggestion(){
            this.selected_suggestion++;

            if(this.selected_suggestion > this.suggestions.length-1){
                this.selected_suggestion = this.suggestions.length-1;
            }
        }
    }
}
